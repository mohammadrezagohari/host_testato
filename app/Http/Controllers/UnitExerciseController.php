<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\summary\SummaryFormulaListRequest;
use App\Http\Requests\summary\SummaryFormulaRequest;
use App\Http\Requests\unitexercise\UnitExerciseListRequest;
use App\Http\Requests\unitexercise\UnitExerciseRequest;
use App\Http\Resources\summary\SummaryFormulaResource;
use App\Http\Resources\unitexercise\UnitExerciseResource;
use App\Repositories\MySQL\UnitExerciseRepository\InterfaceUnitExerciseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group UnitExercise
 *
 * @groupDescription برای بخش خلاصه فرمول از آن استفاده می کنیم و لیست عکس های پیوست شده آن در واقع بخش خلاصه این بخش است .
 *
 * API endpoints for UnitExercise
 *
 * @subgroupDescription برای دسترسی به بخش های UnitExercise موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class UnitExerciseController extends Controller
{

    private InterfaceUnitExerciseRepository $interfaceUnitExerciseRepository;

    public function __construct(InterfaceUnitExerciseRepository $interfaceUnitExerciseRepository)
    {
        $this->interfaceUnitExerciseRepository = $interfaceUnitExerciseRepository;
    }

    /********
     * @param UnitExerciseListRequest $request
     * @return AnonymousResourceCollection
     */
    public function list(UnitExerciseListRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $unit_id = @$request->unit_id;
        $query = $this->interfaceUnitExerciseRepository->query()->withIndex();
        if (@$request->grade_id) {
            $query = $query->where('grade_id', '=', $request->grade_id);
        }
        $result = $query->whereUnit($unit_id)->paginate($count);
        return UnitExerciseResource::collection($result);
    }

    /*****
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $result = $this->interfaceUnitExerciseRepository->query()->withIndex()->paginate($count);
        return UnitExerciseResource::collection($result);
    }


    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {

    }

    /***************
     * Store a newly created resource in storage.
     * @param UnitExerciseRequest $request
     * @return JsonResponse
     */
    public function store(UnitExerciseRequest $request): JsonResponse
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileUrl = upload_unit_exercise_image($image);
        }
        $user = \Auth::user();
        $data = [
            'unit_id' => $request->unit_id,
            'user_id' => $user->id,
            'file_url' => $fileUrl,
        ];

        $newItem = $this->interfaceUnitExerciseRepository->insertData($data);
        if (@$newItem) {
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        }
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /***********************
     * @param int $id
     * @return UnitExerciseResource
     */
    public function show(int $id): UnitExerciseResource
    {
        return UnitExerciseResource::make($this->interfaceUnitExerciseRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit(int $id)
    {
    }

    /**
     * Update the specified resource in storage.
     * @param UnitExerciseRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, UnitExerciseRequest $request): JsonResponse
    {

        $user = \Auth::user();

        $data = [
            'unit_id' => $request->unit_id,
            'user_id' => $user->id,
        ];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['file_url'] = upload_unit_exercise_image($image);
        }

        if ($this->interfaceUnitExerciseRepository->updateItem($id, $data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->interfaceUnitExerciseRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
