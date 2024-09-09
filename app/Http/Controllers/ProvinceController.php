<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\province\ProvinceRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\province\ProvinceResource;
use App\Repositories\MySQL\ProvinceRepository\InterfaceProvinceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Province
 *
 * API endpoints for Province
 *
 * @subgroupDescription برای دسترسی به بخش های Province موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class ProvinceController extends Controller
{
    private InterfaceProvinceRepository $interfaceProvinceRepository;

    public function __construct(InterfaceProvinceRepository $interfaceProvinceRepository)
    {
        $this->interfaceProvinceRepository = $interfaceProvinceRepository;
    }

    public function index(SearchRequest $request)
    {
        $count = @$request->count ?? 10;
        $keyword = @$request->keyword;

        $result = $this->interfaceProvinceRepository->query();
        if (@$keyword)
            $result = $result->searchByName($keyword);

        $result = $result->paginate($count);
        return ProvinceResource::collection($result);
    }


    public function search(SearchRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $keyword = @$request->keyword;
        $result = $this->interfaceProvinceRepository->query()->searchByName($keyword)->paginate($count);
        return ProvinceResource::collection($result);
    }

    /************
     * @return AnonymousResourceCollection
     */
    public function list(): AnonymousResourceCollection
    {
        return ProvinceResource::collection($this->interfaceProvinceRepository->getAll());
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {

    }

    /***************
     * @param ProvinceRequest $request
     * @return JsonResponse
     */
    public function store(ProvinceRequest $request): JsonResponse
    {
        $data = $request->except(["_token"]);
        if ($this->interfaceProvinceRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**************************
     * @param int $id
     * @return ProvinceResource
     */
    public function show(int $id): ProvinceResource
    {
        return ProvinceResource::make($this->interfaceProvinceRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param ProvinceRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, ProvinceRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        if ($this->interfaceProvinceRepository->updateItem($id, $data))
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
        if ($this->interfaceProvinceRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
