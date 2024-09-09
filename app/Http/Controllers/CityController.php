<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\city\CityByProvinceRequest;
use App\Http\Requests\city\CityRequest;
use App\Http\Requests\province\ProvinceRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\city\CityResource;
use App\Http\Resources\province\ProvinceResource;
use App\Repositories\MySQL\CityRepository\InterfaceCityRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group City
 *
 * API endpoints for City Services
 *
 * @subgroupDescription برای دسترسی به بخش های Authentication موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class CityController extends Controller
{
    private InterfaceCityRepository $interfaceCityRepository;

    public function __construct(InterfaceCityRepository $interfaceCityRepository)
    {
        $this->interfaceCityRepository = $interfaceCityRepository;
    }

    public function index(SearchRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $keyword = @$request->keyword;
        $province = @$request->province_id;
        $cities = $this->interfaceCityRepository->query();
        if (@$province)
            $cities = $cities->whereProvinceId($province);

        if (@$keyword)
            $cities = $cities->searchByName($keyword);
        $cities = $cities->paginate($count);
        return CityResource::collection($cities);
    }

    public function list_by_province(CityByProvinceRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $keyword = @$request->keyword;
        $province = @$request->province_id;
        $cities = $this->interfaceCityRepository->query();
        if (@$province)
            $cities = $cities->whereProvinceId($province);

        if (@$keyword)
            $cities = $cities->searchByName($keyword);
        $cities = $cities->paginate($count);
        return CityResource::collection($cities);
    }


    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
    }

    /***************
     * @param CityRequest $request
     * @return JsonResponse
     */
    public function store(CityRequest $request): JsonResponse
    {
        $data = $request->except(["_token"]);
        if ($this->interfaceCityRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**************************
     * @param int $id
     * @return ProvinceResource
     */
    public function show(int $id): ProvinceResource
    {
        return ProvinceResource::make($this->interfaceCityRepository->findById($id));
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
    public function update(int $id, CityRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        if ($this->interfaceCityRepository->updateItem($id, $data))
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
        if ($this->interfaceCityRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
