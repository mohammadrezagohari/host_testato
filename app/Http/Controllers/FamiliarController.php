<?php

namespace App\Http\Controllers;

use App\Http\Requests\familiar\FamiliarRequest;
use App\Http\Requests\school\SchoolRequest;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\familiar\FamiliarResource;
use App\Repositories\MySQL\FamiliarRepository\InterfaceFamiliarRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Familiar
 *
 * API endpoints for Familiar
 *
 * @subgroupDescription برای دسترسی به بخش های Familiar موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class FamiliarController extends Controller
{
    private InterfaceFamiliarRepository $interfaceFamiliarRepository;

    public function __construct(InterfaceFamiliarRepository $interfaceFamiliarRepository)
    {
        $this->interfaceFamiliarRepository = $interfaceFamiliarRepository;
    }

    /**************************
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request):AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $collection = $this->interfaceFamiliarRepository->pagination($count);
        return FamiliarResource::collection($collection);
    }


    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {

    }

    /***************
     * @param FamiliarRequest $request
     * @return JsonResponse
     */
    public function store(FamiliarRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        if ($this->interfaceFamiliarRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /*****************
     * @param int $id
     */
    public function show(int $id)
    {
        return response()->json(['data' => $this->interfaceFamiliarRepository->findById($id)]);
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
     * @param FamiliarRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, FamiliarRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        if ($this->interfaceFamiliarRepository->updateItem($id, $data))
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
        if ($this->interfaceFamiliarRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
