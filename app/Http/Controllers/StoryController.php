<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\story\StoryRequest;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\slider\SliderResource;
use App\Http\Resources\story\StoryResource;
use App\Repositories\MySQL\StoryRepository\InterfaceStoryRepository;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use Verta;

/**
 * @group Story
 *
 * API endpoints for Story
 *
 * @subgroupDescription برای دسترسی به بخش های Story موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class StoryController extends Controller
{
    private InterfaceStoryRepository $interfaceStoryRepository;

    public function __construct(InterfaceStoryRepository $interfaceStoryRepository)
    {
        $this->interfaceStoryRepository = $interfaceStoryRepository;
    }

    /*************
     * Story
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $collection = $this->interfaceStoryRepository->query()->withIndex()->paginate($count);
        return StoryResource::collection($collection);
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
     * @param StoryRequest $request
     * @return JsonResponse
     ********************************************/
    public function store(StoryRequest $request): JsonResponse
    {
        $data = [
            'title' => $request->title,
            'priority_order' => $request->priority_order,
        ];
        if (@$request->file_url) {
            $data['file_url'] = upload_story_file($request->file_url);
        }
        if (@$request->link) {
            $data['link'] = $request->link;
        }
        if (@$request->expire_at) {
            $data['expire_at'] = Verta::parse($request->expire_at)->datetime();
        } else {
            $data['expire_at'] = Carbon::tomorrow()->toDateTime();
        }
        if (@$request->image_preview) {
            $data['image_preview'] = upload_story_file($request->image_preview);
        }
        if ($this->interfaceStoryRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /***********************
     * @param int $id
     * @return StoryResource
     */
    public function show(int $id): StoryResource
    {
        return StoryResource::make($this->interfaceStoryRepository->query()->withIndex()->find($id));
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
     * @param StoryRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, StoryRequest $request): JsonResponse
    {
        $item = $this->interfaceStoryRepository->findById($id);
        $data = [
            'title' => $request->title,
            'link' => $request->link,
            'priority_order' => $request->priority_order,
        ];
        if (@$request->file_url) {
            $data['file_url'] = upload_story_file($request->file_url);
        }
        if (@$request->expire_at) {
            $data['expire_at'] = $request->expire_at;
        } else {
            $data['expire_at'] = Carbon::tomorrow()->toDateTime();
        }
        if (@$request->image_preview) {
            $data['image_preview'] = upload_story_file($request->image_preview);
        }
        if ($this->interfaceStoryRepository->updateItem($id, $data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /******************************
     * change status visited for story
     * @param $storyId
     * @return JsonResponse
     */
    public function visited($storyId): JsonResponse
    {
        $user = Auth::user();
        if (!$user->Stories()->wherePivot('story_id', '=', $storyId)->count()) {
            $user->Stories()->attach($storyId);
        }
        return response()->json(['message' => 'successfully, You visited this story.'], HTTPResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->interfaceStoryRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
