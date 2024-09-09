<?php

namespace App\Http\Controllers;

use App\Enums\QuestionCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\bookmark\BookmarkRequest;
use App\Http\Requests\bookmark\ChangeCategoryRequest;
use App\Http\Requests\bookmark\MyBookmarkListRequest;
use App\Http\Resources\bookmark\BookmarkResource;
use App\Repositories\MySQL\BookmarkRepository\InterfaceBookmarkRepository;
use App\Repositories\MySQL\CategoryRepository\InterfaceCategoryRepository;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Bookmark
 *
 * API endpoints for BookMark
 *
 * @subgroupDescription برای دسترسی به بخش های BookMark موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class BookmarkController extends Controller
{
    private InterfaceBookmarkRepository $interfaceBookmarkRepository;
    private InterfaceCategoryRepository $interfaceCategoryRepository;

    public function __construct(InterfaceBookmarkRepository $interfaceBookmarkRepository, InterfaceCategoryRepository $interfaceCategoryRepository)
    {
        $this->interfaceBookmarkRepository = $interfaceBookmarkRepository;
        $this->interfaceCategoryRepository = $interfaceCategoryRepository;
    }

    public function index(Request $request)
    {
        $count = @$request->count ?? 10;
        $collection = $this->interfaceBookmarkRepository->query()->withIndex()->paginate($count);
        return BookmarkResource::collection($collection);
    }

    /************
     * @return AnonymousResourceCollection
     */
    public function list(): AnonymousResourceCollection
    {
        return BookmarkResource::collection($this->interfaceBookmarkRepository->getAll());
    }

    public function list_my_bookmark(MyBookmarkListRequest $request): AnonymousResourceCollection
    {
        $user = Auth::user();
        $query = $this->interfaceBookmarkRepository->query()->where('user_id', '=', $user->id);
        if (@$this->interfaceCategoryRepository->findById($request->category_id)->name == QuestionCategory::AllQuestion) {
            $query = $query->get();
        } else {
            $query = $query->where('category_id', '=', $request->category_id)->get();
        }
        return BookmarkResource::collection($query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /***************
     * Store a newly created resource in storage.
     * @param BookmarkRequest $request
     * @return JsonResponse
     */
    public function store(BookmarkRequest $request): JsonResponse
    {
        $user = Auth::user();
        $result = null;
        $data = [
            'description' => $request->description,
            'question_id' => $request->question_id,
            'category_id' => $request->category_id,
            'user_id' => $user->id,
        ];

        $item = $this->interfaceBookmarkRepository->query()->where('question_id', '=', $request->question_id)
            ->where('user_id', '=', $user->id)->first();

        if (@$item) {
            $result = $this->interfaceBookmarkRepository->updateItem($item->id, $data);
        } else {
            $result = $this->interfaceBookmarkRepository->insertData($data);
        }

        if (@$result)
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /*****************
     * @param int $id
     * @return BookmarkResource
     */
    public function show(int $id): BookmarkResource
    {
        return BookmarkResource::make($this->interfaceBookmarkRepository->findById($id));
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


    public function change_category(ChangeCategoryRequest $request)
    {
        try {
            $this->interfaceBookmarkRepository->updateItem($request->bookmark_id, [
                'category_id' => $request->category_id
            ]);
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function delete_from_category($id)
    {
        try {
            if ($this->interfaceBookmarkRepository->deleteData($id)) {
                return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
            }
            return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Update the specified resource in storage.
     * @param BookmarkRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, BookmarkRequest $request): JsonResponse
    {
        $user = Auth::user();
        $data = [
            'description' => $request->description,
            'question_id' => $request->question_id,
            'category_id' => $request->category_id,
            'user_id' => $user->id,
        ];
        if ($this->interfaceBookmarkRepository->updateItem($id, $data))
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
        if ($this->interfaceBookmarkRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }


}
