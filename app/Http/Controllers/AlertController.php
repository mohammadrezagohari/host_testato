<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alert\AlertRequest;
use App\Http\Resources\Alert\AlertResource;
use App\Repositories\MySQL\AlertRepository\InterfaceAlertRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Alert
 *
 * API endpoints for Alert
 *
 * @subgroupDescription برای دسترسی به بخش های Alert موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class AlertController extends Controller
{
    private InterfaceAlertRepository $interfaceAlertRepository;

    public function __construct(InterfaceAlertRepository $interfaceAlertRepository)
    {
        $this->interfaceAlertRepository = $interfaceAlertRepository;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $keyword = @$request->keyword;
        $collection = $this->interfaceAlertRepository->query();

        if (@$keyword)
            $collection = $collection->searchByName($keyword);
        $collection = $collection->paginate($count);
        return AlertResource::collection($collection);
    }

    /***************
     * @param AlertRequest $request
     * @return JsonResponse
     */
    public function store(AlertRequest $request): JsonResponse
    {
        $data = $request->except(["_token"]);
        if ($this->interfaceAlertRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**************************
     * @param int $id
     * @return AlertResource
     */
    public function show(int $id): AlertResource
    {
        return AlertResource::make($this->interfaceAlertRepository->findById($id));
    }

    /**
     * Update the specified resource in storage.
     * @param AlertRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, AlertRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        if ($this->interfaceAlertRepository->updateItem($id, $data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        if ($this->interfaceAlertRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }
}

