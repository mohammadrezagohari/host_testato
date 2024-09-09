<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\course\CourseRequest;
use App\Http\Requests\level\LevelBySectionRequest;
use App\Http\Requests\level\LevelRequest;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\course\CourseResource;
use App\Http\Resources\level\LevelResource;
use App\Models\Level;
use App\Repositories\MySQL\LevelRepository\InterfaceLevelRepository;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Level
 *
 * API endpoints for Level
 *
 * @subgroupDescription برای دسترسی به بخش های Level موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class LevelController extends Controller
{
    private InterfaceLevelRepository $interfaceLevelRepository;

    public function __construct(InterfaceLevelRepository $interfaceLevelRepository)
    {
        $this->interfaceLevelRepository = $interfaceLevelRepository;
    }

    /*******************
     * Question Banks
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $count = @$request->count ?? 10;
        $result = $this->interfaceLevelRepository->query()->withIndexSection()->orderByDesc("id")->paginate($count);
        return LevelResource::collection($result);
    }


    public function list(LevelBySectionRequest $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $result = $this->interfaceLevelRepository->query()->withIndexSection()->whereSectionId($request->section_id)
            ->orderBy("order")
            ->paginate($count);
        return LevelResource::collection($result);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /********************************************
     * Store a newly created resource in storage.
     * @param LevelRequest $request
     * @return JsonResponse
     */
    public function store(LevelRequest $request): JsonResponse
    {
        $data = [
            'title' => $request->title,
            'section_id' => $request->section_id,
        ];

        if (@$request->order) {
            $data['order'] = $request->order;
        }
        if (@$request->quantity_questions) {
            $data['quantity_questions'] = $request->quantity_questions;
        }
        if (@$request->answer_quantity) {
            $data['answer_quantity'] = $request->answer_quantity;
        }
        if ($this->interfaceLevelRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /*****************
     * @param int $id
     * @return LevelResource
     */
    public function show(int $id): LevelResource
    {
        return new LevelResource($this->interfaceLevelRepository->findById($id));
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
     * @param LevelRequest $request
     * @param int $id
      * @return JsonResponse
     */
    public function update(int $id, LevelRequest $request): JsonResponse
    {
        $data = [
            'title' => $request->title,
            'section_id' => $request->section_id,
        ];
        if (@$request->order) {
            $data['order'] = $request->order;
        }
        if (@$request->quantity_questions) {
            $data['quantity_questions'] = $request->quantity_questions;
        }
        if (@$request->answer_quantity) {
            $data['answer_quantity'] = $request->answer_quantity;
        }
        if ($this->interfaceLevelRepository->updateItem($id, $data))
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
        if ($this->interfaceLevelRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }


}
