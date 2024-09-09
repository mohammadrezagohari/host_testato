<?php

namespace App\Http\Controllers;

use App\Enums\BaseInfo;
use App\Http\Controllers\Controller;
use App\Http\Requests\bookmark\BookmarkRequest;
use App\Http\Requests\category\CategoryRequest;
use App\Http\Requests\course\CourseRequest;
use App\Http\Resources\bookmark\BookmarkResource;
use App\Http\Resources\category\CategoryResource;
use App\Http\Resources\course\CourseResource;
use App\Repositories\MySQL\CategoryRepository\InterfaceCategoryRepository;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Category
 *
 * API endpoints for Category
 *
 * @subgroupDescription برای دسترسی به بخش های Category موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class CategoryController extends Controller
{
    private InterfaceCategoryRepository $interfaceCategoryRepository;

    public function __construct(InterfaceCategoryRepository $interfaceCategoryRepository)
    {
        $this->interfaceCategoryRepository = $interfaceCategoryRepository;
    }


    public function index(Request $request)
    {
        $count = @$request->count ?? 10;
        $collection = $this->interfaceCategoryRepository->query()->withIndex()->paginate($count);
        return CategoryResource::collection($collection);
    }

    public function list_user(): AnonymousResourceCollection
    {
        $user = Auth::user();
        return CategoryResource::collection($this->interfaceCategoryRepository->query()->where('user_id', '=', $user->id)->get());
    }

    public function list(): AnonymousResourceCollection
    {
        return CategoryResource::collection($this->interfaceCategoryRepository->getAll());
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
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $user = Auth::user();
        $data = [
            'name' => $request->name,
            'user_id' => $user->id,
            'is_all' => false
        ];
        if (!$user->Category()->where('is_all', '=', true)->count()) {
            $this->interfaceCategoryRepository->insertData([
                'name' => BaseInfo::categoryAll,
                'user_id' => $user->id,
                'is_all' => true
            ]);
        }
        $result = $this->interfaceCategoryRepository->insertData($data);
        if (@$result)
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'category_id' => $result->id], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /*****************
     * @param int $id
     * @return CategoryResource
     */
    public function show(int $id): CategoryResource
    {
        return CategoryResource::make($this->interfaceCategoryRepository->findById($id));
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
     * @param CategoryRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, CategoryRequest $request): JsonResponse
    {
        $data = [
            'name' => $request->name,
            'user_id' => Auth::user()->id,
        ];
        if ($this->interfaceCategoryRepository->updateItem($id, $data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
//        if (@$id === 1) {
//            return response()->json(['message' => "sorry, you can't delete All category!"], HTTPResponse::HTTP_BAD_REQUEST);
//        }
        if (@$id && $this->interfaceCategoryRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

}
