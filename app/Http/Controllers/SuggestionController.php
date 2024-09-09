<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\menu\MenuRequest;
use App\Http\Requests\suggestion\SuggestionRequest;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\menu\MenuResource;
use App\Http\Resources\suggestion\SuggestionResource;
use App\Repositories\MySQL\SuggestionRepository\InterfaceSuggestionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Suggestion
 *
 * API endpoints for Suggestion
 *
 * @subgroupDescription برای دسترسی به بخش های Suggestion موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class SuggestionController extends Controller
{
    private InterfaceSuggestionRepository $interfaceSuggestionRepository;

    public function __construct(InterfaceSuggestionRepository $interfaceSuggestionRepository)
    {
        $this->interfaceSuggestionRepository = $interfaceSuggestionRepository;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $menus = $this->interfaceSuggestionRepository->pagination($count);
        return SuggestionResource::collection($menus);
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
     * @param SuggestionRequest $request
     * @return JsonResponse
     */
    public function store(SuggestionRequest $request): JsonResponse
    {
        $data =[
            'user_id'=>\Auth::user()->id,
            'context'=>$request->context,
        ];
        if ($this->interfaceSuggestionRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /*****************
     * @param int $id
     * @return SuggestionResource
     */
    public function show(int $id): SuggestionResource
    {
        return SuggestionResource::make($this->interfaceSuggestionRepository->findById($id));
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
     * @param SuggestionRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, SuggestionRequest $request): JsonResponse
    {
        $data =[
            'user_id'=>\Auth::user()->id,
            'context'=>$request->context,
        ];
        if ($this->interfaceSuggestionRepository->updateItem($id, $data))
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
        if ($this->interfaceSuggestionRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }


}
