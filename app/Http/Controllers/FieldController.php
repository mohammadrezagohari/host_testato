<?php

namespace App\Http\Controllers;

use App\Http\Requests\field\FieldRequest;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\field\FieldResource;
use App\Repositories\MySQL\FieldRepository\InterfaceFieldRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Field
 *
 * API endpoints for Field
 *
 * @subgroupDescription برای دسترسی به بخش های Field موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class FieldController extends Controller
{
    private InterfaceFieldRepository $interfaceFieldRepository;

    public function __construct(InterfaceFieldRepository $interfaceFieldRepository)
    {
        $this->interfaceFieldRepository = $interfaceFieldRepository;
    }

    public function index(Request $request)
    {
        $count = @$request->count ?? 10;
        $grades = $this->interfaceFieldRepository->pagination($count);
        return new BaseCollection($grades);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function store(FieldRequest $request): JsonResponse
    {
        $data = [
            'name' => $request->name,
        ];
        if ($this->interfaceFieldRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /*****************
     * @param int $id
     * @return FieldResource
     */
    public function show(int $id): FieldResource
    {
        return FieldResource::make($this->interfaceFieldRepository->findById($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        //
    }

    public function update(int $id, FieldRequest $request): JsonResponse
    {
        $data = [
            'name' => $request->name,
        ];
        if ($this->interfaceFieldRepository->updateItem($id, $data))
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
        if ($this->interfaceFieldRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
