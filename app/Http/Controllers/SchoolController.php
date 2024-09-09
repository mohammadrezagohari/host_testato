<?php

namespace App\Http\Controllers;

use App\Http\Requests\school\SchoolRequest;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\menu\MenuResource;
use App\Http\Resources\school\SchoolResouce;
use App\Repositories\MySQL\SchoolRepository\InterfaceSchoolRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group School
 *
 * API endpoints for School
 *
 * @subgroupDescription برای دسترسی به بخش های School موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class SchoolController extends Controller
{
    private InterfaceSchoolRepository $interfaceSchoolRepository;

    public function __construct(InterfaceSchoolRepository $interfaceSchoolRepository)
    {
        $this->interfaceSchoolRepository = $interfaceSchoolRepository;
    }

    /**************************
     * @param Request $request
     * @return BaseCollection
     */
    public function index(Request $request): BaseCollection
    {
        $count = @$request->count ?? 10;
        $menus = $this->interfaceSchoolRepository->pagination($count);
        return new BaseCollection($menus);
    }


    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {

    }

    /***************
     * @param SchoolRequest $request
     * @return JsonResponse
     */
    public function store(SchoolRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        if ($this->interfaceSchoolRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /*****************
     * @param int $id
     */
    public function show(int $id)
    {
        return response()->json(['data' => $this->interfaceSchoolRepository->findById($id)]);
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
     * @param SchoolRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, SchoolRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        if ($this->interfaceSchoolRepository->updateItem($id, $data))
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
        if ($this->interfaceSchoolRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
