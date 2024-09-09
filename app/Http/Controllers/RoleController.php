<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\role\RoleRequest;
use App\Http\Resources\role\RoleResource;
use App\Repositories\MySQL\RoleRepository\InterfaceRoleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Role
 *
 * API endpoints for Role
 *
 * @subgroupDescription برای دسترسی به بخش های Role موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class RoleController extends Controller
{
    private InterfaceRoleRepository $interfaceRoleRepository;

    public function __construct(InterfaceRoleRepository $interfaceRoleRepository)
    {
        $this->interfaceRoleRepository = $interfaceRoleRepository;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $keyword = @$request->keyword;
        $collection = $this->interfaceRoleRepository->query();

        if (@$keyword)
            $collection = $collection->searchByName($keyword);
        $collection = $collection->paginate($count);
        return RoleResource::collection($collection);
    }

    /***************
     * @param RoleRequest $request
     * @return JsonResponse
     */
    public function store(RoleRequest $request): JsonResponse
    {
        $data = $request->except(["_token"]);
        if ($this->interfaceRoleRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**************************
     * @param int $id
     * @return RoleResource
     */
    public function show(int $id): RoleResource
    {
        return RoleResource::make($this->interfaceRoleRepository->findById($id));
    }

    /**
     * Update the specified resource in storage.
     * @param RoleRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, RoleRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        if ($this->interfaceRoleRepository->updateItem($id, $data))
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
        if ($this->interfaceRoleRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }
}

