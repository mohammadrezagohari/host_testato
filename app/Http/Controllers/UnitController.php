<?php

namespace App\Http\Controllers;

use App\Http\Requests\unit\UnitByFilterRequest;
use App\Http\Requests\unit\UnitRequest;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\unit\UnitListResource;
use App\Http\Resources\unit\UnitResource;
use App\Repositories\MySQL\UnitRepository\InterfaceUnitRepository;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Storage;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Unit
 *
 * API endpoints for Unit
 *
 * @subgroupDescription برای دسترسی به بخش های Unit موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class UnitController extends Controller
{
    private InterfaceUnitRepository $interfaceUnitRepository;

    public function __construct(InterfaceUnitRepository $interfaceUnitRepository)
    {
        $this->interfaceUnitRepository = $interfaceUnitRepository;
    }

    public function index(Request $request)
    {
        $count = @$request->count ?? 10;
        $result = $this->interfaceUnitRepository->query()->withIndex()->orderByDesc("id")->paginate($count);
        return UnitResource::collection($result);
    }


    public function units_by_course(Request $request, $courseId): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $result = $this->interfaceUnitRepository->query()->withIndex()->where('course_id', '=', $courseId)->orderByDesc("id")->paginate($count);
        return UnitResource::collection($result);
    }
    public function units_by_course_grade(Request $request, $courseId,$gradeId): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $result = $this->interfaceUnitRepository->query()->withIndex()->where('course_id', '=', $courseId)->where('grade_id', '=', $gradeId)->orderByDesc("id")->paginate($count);
        return UnitResource::collection($result);
    }

    public function list(UnitByFilterRequest $request): AnonymousResourceCollection
    {
        $gradeId = $request->grade_id;
        $course_id = $request->course_id;
        $count = @$request->count ?? 10;
        $result = $this->interfaceUnitRepository->query()->withIndex();

        if (@$request->course_id)
            $result = $result->whereCourse($course_id);
        if (@$request->grade_id)
            $result = $result->whereGrade($gradeId);


        return UnitListResource::collection($result->paginate($count));
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
     * @param UnitRequest $request
     * @return JsonResponse
     */
    public function store(UnitRequest $request): JsonResponse
    {
        $fileUrl = null;
        $image = $request->file('image');
        if (@$image) {
            $fileUrl = upload_unit_image($image);
        }
        $data = [
            'title' => $request->title,
            'course_id' => $request->course_id,
            'grade_id' => $request->grade_id,
        ];
        $fields = $request->field_ids;

        $newItem = $this->interfaceUnitRepository->insertData($data);
        if (@$newItem) {
            if (@$fileUrl) {
                $newItem->UnitAttachments()->create([
                    'image_url' => $fileUrl
                ]);
            }
            if (@$fields) {
                $newItem->Fields()->attach($fields);
            }
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        }
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /***********************
     * @param int $id
     * @return UnitResource
     */
    public function show(int $id): UnitResource
    {
        return UnitResource::make($this->interfaceUnitRepository->findById($id));
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
     * @param UnitRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, UnitRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $fileUrl = null;
            $image = $request->file('image');
            $fields = $request->field_ids;
            if (@$image) {
                $fileUrl = upload_unit_image($image);
            }
            $data = [
                'title' => $request->title,
                'course_id' => $request->course_id,
                'grade_id' => $request->grade_id,
            ];
            if (@$this->interfaceUnitRepository->updateItem($id, $data)) {
                $item = $this->interfaceUnitRepository->findById($id);
                $currentAttachment = $item->UnitAttachments()->first();
                if (@$fileUrl) {
                    $currentAttachment->update([
                        'image_url' => $fileUrl
                    ]);
                }
                if (@$fields) {
                    $item->Fields()->sync($fields);
                }
                DB::commit();
                return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
            }
            DB::rollBack();
            return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['error' => $exception->getMessage(), "line" => $exception->getLine()], $exception->getCode());
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
        try {
            $item = $this->interfaceUnitRepository->findById($id);
            DB::beginTransaction();

            foreach ($item->UnitAttachments as $current) {
                if (@$current) {
                    Storage::delete($current->image_url);
                    $current->delete();
                }
            }
            $item->Fields()->detach();
            $item->UnitAttachments()->delete();

            ////TODO: Dependency to exercise has problem because has relationship
            if ($this->interfaceUnitRepository->deleteData($id)) {
                DB::commit();
                return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
            }
            return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'line' => $exception->getLine(), "status" => false], HTTPResponse::HTTP_EXPECTATION_FAILED);
        }

    }
}
