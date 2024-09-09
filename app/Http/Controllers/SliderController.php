<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\slider\SliderRequest;
use App\Http\Requests\unit\UnitRequest;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\slider\SliderResource;
use App\Http\Resources\unit\UnitResource;
use App\Repositories\MySQL\SliderRepository\InterfaceSliderRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
/**
 * @group SlideShow
 *
 * لیست API های اسلایدر
 *
 * @subgroupDescription برای دسترسی به بخش های اسلاید شو موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */

class SliderController extends Controller
{
    private InterfaceSliderRepository $interfaceSliderRepository;

    public function __construct(InterfaceSliderRepository $interfaceSliderRepository)
    {
        $this->interfaceSliderRepository = $interfaceSliderRepository;
    }
    /**************************************
     * لیست اسلاید ها به همراه صفحه بندی
     * @param Request $request
     * @return AnonymousResourceCollection
     **************************************/
    public function index(Request $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $collection = $this->interfaceSliderRepository->query()->orderBy("priority_order")->orderByDesc("id")->paginate($count);
        return SliderResource::collection($collection);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {

    }

    /********************************************
     * Store a newly created resource in storage.
     * @param SliderRequest $request
     * @return JsonResponse
     ********************************************/
    public function store(SliderRequest $request): JsonResponse
    {
        $file = upload_slider_file($request->file_url);

        $data = [
            'title' => $request->title,
            'priority_order' => $request->priority_order,
            'file_url' => $file,
            'mime_type' => $request->mime_type,
            'file_size' => $request->file_size,
        ];
        if ($this->interfaceSliderRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /***********************
     * @param int $id
     * @return SliderResource
     */
    public function show(int $id): SliderResource
    {
        return SliderResource::make($this->interfaceSliderRepository->findById($id));
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
     * @param SliderRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, SliderRequest $request): JsonResponse
    {

        $data = [
            'title' => $request->title,
            'priority_order' => $request->priority_order,
            'mime_type' => $request->mime_type,
            'file_size' => $request->file_size,
        ];
        if  ($request->hasFile("file_url"))
            $data["file_url"] = upload_slider_file($request->file_url);

        if ($this->interfaceSliderRepository->updateItem($id, $data))
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
        if ($this->interfaceSliderRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
