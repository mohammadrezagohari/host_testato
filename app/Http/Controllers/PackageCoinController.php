<?php

namespace App\Http\Controllers;

use App\Enums\BaseInfo;
use App\Http\Controllers\Controller;
use App\Http\Requests\package\PackageCoinRequest;
use App\Http\Requests\suggestion\SuggestionRequest;
use App\Http\Resources\package\PackageCoinResource;
use App\Http\Resources\suggestion\SuggestionResource;
use App\Repositories\MySQL\BaseInfoRepository\InterfaceBaseInfoRepository;
use App\Repositories\MySQL\PackageCoinRepository\InterfacePackageCoinRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group PackageCoin
 *
 * API endpoints for PackageCoin
 *
 * @subgroupDescription برای دسترسی به بخش های PackageCoin موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class PackageCoinController extends Controller
{
    private InterfacePackageCoinRepository $interfacePackageCoinRepository;
    private InterfaceBaseInfoRepository $interfaceBaseInfoRepository;

    public function __construct(InterfacePackageCoinRepository $interfacePackageCoinRepository,InterfaceBaseInfoRepository $interfaceBaseInfoRepository)
    {
        $this->interfacePackageCoinRepository = $interfacePackageCoinRepository;
        $this->interfaceBaseInfoRepository = $interfaceBaseInfoRepository;
    }

    public function list(Request $request)
    {
        $count = @$request->count ?? 10;
        $baseInfo = $this->interfaceBaseInfoRepository->findFirstSection(BaseInfo::CostCoinsPart,\App\Enums\BaseInfo::CostPerQuestionGold);
        return PackageCoinResource::collection($this->interfacePackageCoinRepository->paginate($count))->additional([
            'amount_value'=> (int) $baseInfo->value
        ]);
    }


    public function index(Request $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $menus = $this->interfacePackageCoinRepository->pagination($count);
        return PackageCoinResource::collection($menus);
    }


    /********************************************
     * Show the form for creating a new resource.
     *
     * @return Response
     ********************************************/
    public function create()
    {

    }

    /***************
     * @param PackageCoinRequest $request
     * @return JsonResponse
     */
    public function store(PackageCoinRequest $request): JsonResponse
    {
        $data =[
            'title'=>$request->title,
            'quantity'=>$request->quantity,
        ];
        if ($this->interfacePackageCoinRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /*****************
     * @param int $id
     * @return PackageCoinResource
     */
    public function show(int $id): PackageCoinResource
    {
        return PackageCoinResource::make($this->interfacePackageCoinRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param PackageCoinRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, PackageCoinRequest $request): JsonResponse
    {
        $data =[
            'title'=>$request->title,
            'quantity'=>$request->quantity,
        ];
        if ($this->interfacePackageCoinRepository->updateItem($id, $data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        if ($this->interfacePackageCoinRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }


}
