<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coin\CoinRequest;
use App\Http\Resources\Coin\CoinResource;
use App\Repositories\MySQL\CoinRepository\InterfaceCoinRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Coin
 *
 * API endpoints for Coin
 *
 * @subgroupDescription برای دسترسی به بخش های Coin موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class CoinController extends Controller
{
    private InterfaceCoinRepository $interfaceCoinRepository;

    public function __construct(InterfaceCoinRepository $interfaceCoinRepository)
    {
        $this->interfaceCoinRepository = $interfaceCoinRepository;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $keyword = @$request->keyword;
        $collection = $this->interfaceCoinRepository->query();

        if (@$keyword)
            $collection = $collection->searchByName($keyword);
        $collection = $collection->paginate($count);
        return CoinResource::collection($collection);
    }

    /***************
     * @param CoinRequest $request
     * @return JsonResponse
     */
    public function store(CoinRequest $request): JsonResponse
    {
        $data = $request->except(["_token"]);
        if ($this->interfaceCoinRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**************************
     * @param int $id
     * @return CoinResource
     */
    public function show(int $id): CoinResource
    {
        return CoinResource::make($this->interfaceCoinRepository->findById($id));
    }

    /**
     * Update the specified resource in storage.
     * @param CoinRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, CoinRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        if ($this->interfaceCoinRepository->updateItem($id, $data))
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
        if ($this->interfaceCoinRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }
}

