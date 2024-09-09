<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\summary\SummaryFormulaListRequest;
use App\Http\Requests\summary\SummaryFormulaRequest;
use App\Http\Resources\summary\SummaryFormulaResource;
use App\Repositories\MySQL\SummaryFormulaRepository\InterfaceSummaryFormulaRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group SummaryFormula
 *
 * @groupDescription برای بخش خلاصه فرمول از آن استفاده می کنیم و لیست عکس های پیوست شده آن در واقع بخش خلاصه این بخش است .
 *
 * API endpoints for SummaryFormula
 *
 * @subgroupDescription برای دسترسی به بخش های SummaryFormula موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class SummaryFormulaController extends Controller
{
    private InterfaceSummaryFormulaRepository $interfaceSummaryFormulaRepository;

    public function __construct(InterfaceSummaryFormulaRepository $interfaceSummaryFormulaRepository)
    {
        $this->interfaceSummaryFormulaRepository = $interfaceSummaryFormulaRepository;
    }

    /********
     * @param SummaryFormulaListRequest $request
     * @return AnonymousResourceCollection
     */
    public function list(SummaryFormulaListRequest $request):AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $unit_id = @$request->unit_id;
        $result = $this->interfaceSummaryFormulaRepository->query()->withIndex()->whereUnit($unit_id)->paginate($count);
        return SummaryFormulaResource::collection($result);
    }

    /*****
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $result = $this->interfaceSummaryFormulaRepository->query()->withIndex()->paginate($count);
        return SummaryFormulaResource::collection($result);
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
     * @param SummaryFormulaRequest $request
     * @return JsonResponse
     */
    public function store(SummaryFormulaRequest $request): JsonResponse
    {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $fileUrl = env('app_url') . '/images/summary/' . $imageName;
        $data = [
            'unit_id' => $request->unit_id,
            'user_id' => \Auth::user()->id,
            'file_url' => $fileUrl,
        ];

        $newItem = $this->interfaceSummaryFormulaRepository->insertData($data);
        if (@$newItem) {
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        }
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /***********************
     * @param int $id
     * @return SummaryFormulaResource
     */
    public function show(int $id): SummaryFormulaResource
    {
        return SummaryFormulaResource::make($this->interfaceSummaryFormulaRepository->findById($id));
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
     * @param SummaryFormulaRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, SummaryFormulaRequest $request): JsonResponse
    {
        $image = $request->file('image');
        $data = [
            'unit_id' => $request->unit_id,
            'user_id' => \Auth::user()->id,
        ];
        if (@$image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $fileUrl = env('app_url') . '/images/summary/' . $imageName;
            $data['file_url'] = $fileUrl;
        }


        if ($this->interfaceSummaryFormulaRepository->updateItem($id, $data))
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
        if ($this->interfaceSummaryFormulaRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

}
