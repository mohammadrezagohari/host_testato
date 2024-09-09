<?php

namespace App\Http\Controllers;

use App\Http\Requests\grade\GradeRequest;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\grade\GradeResource;
use App\Repositories\MySQL\GradeRepository\InterfaceGradeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Grade
 *
 * API endpoints for Grade
 *
 * @subgroupDescription برای دسترسی به بخش های Grade موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class GradeController extends Controller
{
    private InterfaceGradeRepository $gradeRepositoryInterface;

    public function __construct(InterfaceGradeRepository $gradeRepositoryInterface)
    {
        $this->gradeRepositoryInterface = $gradeRepositoryInterface;
    }

    public function index(Request $request)
    {
        $count = @$request->count ?? 10;
        $collection = $this->gradeRepositoryInterface->pagination($count);
        return new BaseCollection($collection);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /***************
     * Store a newly created resource in storage.
     * @param GradeRequest $request
     * @return JsonResponse
     */
    public function store(GradeRequest $request): JsonResponse
    {
        $data = [
            'name' => $request->name,
            'priority' => $request->priority,
        ];

        if ($this->gradeRepositoryInterface->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /*****************
     * @param int $id
     * @return GradeResource
     */
    public function show(int $id): GradeResource
    {
        return GradeResource::make($this->gradeRepositoryInterface->findById($id));
    }
//
//
//    public function grade_by_field(int $id,Request $request)
//    {
//        $count = @$request->count ?? 10;
//        $grades =$this->gradeRepositoryInterface->query()->with(['Field'])->where('field_id', '=', $id)->paginate($count);
//        return new BaseCollection($grades);
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param GradeRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, GradeRequest $request): JsonResponse
    {
        $data = [
            'name' => $request->name,
            'priority' => $request->priority,
        ];

        if ($this->gradeRepositoryInterface->updateItem($id, $data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->gradeRepositoryInterface->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
