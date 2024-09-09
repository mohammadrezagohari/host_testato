<?php

namespace App\Http\Controllers;

use App\Http\Requests\course\CourseRequest;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\course\CourseCollection;
use App\Http\Resources\course\CourseResource;
use App\Http\Resources\course\CoursesLandingResource;
use App\Repositories\MySQL\CourseRepository\InterfaceCourseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Course
 *
 * API endpoints for Course
 *
 * @subgroupDescription برای دسترسی به بخش های Course موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class CourseController extends Controller
{
    /**********************************
     * @var InterfaceCourseRepository
     *********************************/
    private InterfaceCourseRepository $interfaceCourseRepository;

    /**************************
     * @param InterfaceCourseRepository $interfaceCourseRepository
     */
    public function __construct(InterfaceCourseRepository $interfaceCourseRepository)
    {
        $this->interfaceCourseRepository = $interfaceCourseRepository;
    }

    /*******************
     * Question Banks
     * @param Request $request
     */
    public function index(Request $request)
    {
        $count = @$request->count ?? 10;
        $grade_id = null;
        if (@$request->grade_id) {
            $grade_id = $request->grade_id;
        }

        $collection = $this->interfaceCourseRepository->query()->withIndex()->orderByDesc("id")->paginate($count);
        return CourseCollection::collection($collection)->additional(['grade_me' => $grade_id]);
    }

    /************
     * @return AnonymousResourceCollection
     */
    public function list(): AnonymousResourceCollection
    {
        return CourseResource::collection($this->interfaceCourseRepository->query()->withIndex()->get());
    }

    public function list_with_count(): AnonymousResourceCollection
    {
        return CoursesLandingResource::collection($this->interfaceCourseRepository->getAll());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /***************
     * Store a newly created resource in storage.
     * @param CourseRequest $request
     * @return JsonResponse
     */
    public function store(CourseRequest $request): JsonResponse
    {
        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];
        if (@$request->file('icon')) {
            $data['icon'] = upload_asset_file($request->file('icon'));
        }
        if (@$request->background) {
            $data['background'] = $request->background;
        }
        if ($this->interfaceCourseRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /*****************
     * @param int $id
     * @return CourseResource
     */
    public function show(int $id): CourseResource
    {
        return CourseResource::make($this->interfaceCourseRepository->findById($id));
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
     * @param CourseRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, CourseRequest $request): JsonResponse
    {
        try {
            $item = $this->interfaceCourseRepository->findById($id);
            $data = [
                'title' => $request->title,
                'description' => $request->description,
            ];
            if (@$request->file('icon')) {
                delete_data_upload($item->icon);
                $data['icon'] = upload_asset_file($request->file('icon'));
            }
            if (@$request->background) {
                $data['background'] = $request->background;
            }

            if ($this->interfaceCourseRepository->updateItem(identity: $id, data: $data))
                return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
            return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);

        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->interfaceCourseRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }


//    public function course_by_grade($grade_id, Request $request): AnonymousResourceCollection
//    {
//        $count = @$request->count ?? 10;
//        $data = $this->interfaceCourseRepository->query()
//            ->withIndexUnits()
//            ->whereUnitsIsUnderGrade($grade_id)->paginate($count);
//        return CourseResource::collection($data);
//    }

//    public function course_by_grade_and_field(CourseHasFieldAndGradeRequest $request): AnonymousResourceCollection
//    {
//        $count = @$request->count ?? 10;
//        $field = @$request->field_id;
//        $grade = @$request->grade_id;
//        $data = $this->interfaceCourseRepository->query()
//            ->withIndexUnits()
//            ->whereCourseHasGradeAndField($grade,$field)->paginate($count);
//        return CourseResource::collection($data);
//    }
}
