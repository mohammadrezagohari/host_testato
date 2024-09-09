<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\section\SectionByUnitRequest;
use App\Http\Requests\section\SectionRequest;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\section\SectionResource;
use App\Repositories\MySQL\SectionRepository\InterfaceSectionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Section
 *
 * API endpoints for Section
 *
 * @subgroupDescription برای دسترسی به بخش های Section موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */

class SectionController extends Controller
{
    private InterfaceSectionRepository $interfaceSectionRepository;

    public function __construct(InterfaceSectionRepository $interfaceSectionRepository)
    {
        $this->interfaceSectionRepository = $interfaceSectionRepository;
    }

    public function index(Request $request): BaseCollection
    {
        $count = @$request->count ?? 10;
        $result=$this->interfaceSectionRepository->query()->withIndex()->paginate($count);
        return new BaseCollection($result);
    }

    /*****************
     * @param SectionByUnitRequest $request
     * @return BaseCollection
     */
    public function list(SectionByUnitRequest $request): BaseCollection
    {
        $count = @$request->count ?? 10;
        $unit_id = $request->unit_id;
        $result=$this->interfaceSectionRepository->query()->withIndex()->whereUnit($unit_id)->paginate($count);
        return new BaseCollection($result);
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
     * @param SectionRequest $request
     * @return JsonResponse
     */
    public function store(SectionRequest $request): JsonResponse
    {
        $data = [
            'title' => $request->title,
            'unit_id' => $request->unit_id,
        ];

        if ($this->interfaceSectionRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /***********************
     * @param int $id
     * @return SectionResource
     */
    public function show(int $id)
    {
        return SectionResource::make($this->interfaceSectionRepository->find($id));
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
     * @param SectionRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, SectionRequest $request): JsonResponse
    {
        $data = [
            'title' => $request->title,
            'unit_id' => $request->unit_id,
        ];
        if ($this->interfaceSectionRepository->updateItem($id, $data))
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
        if ($this->interfaceSectionRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
