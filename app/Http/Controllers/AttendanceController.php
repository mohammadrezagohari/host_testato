<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\AttendanceRequest;
use App\Http\Resources\Attendance\AttendanceResource;
use App\Models\User;
use App\Repositories\MySQL\AttendanceRepository\InterfaceAttendanceRepository;
use App\Repositories\MySQL\ProfileRepository\InterfaceProfileRepository;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Attendance
 *
 * API endpoints for Attendance
 *
 * @subgroupDescription برای دسترسی به بخش های Attendance موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class AttendanceController extends Controller
{
    private InterfaceAttendanceRepository $interfaceAttendanceRepository;
    private InterfaceProfileRepository $interfaceProfileRepository;

    public function __construct(InterfaceAttendanceRepository $interfaceAttendanceRepository,InterfaceProfileRepository $interfaceProfileRepository)
    {
        $this->interfaceAttendanceRepository = $interfaceAttendanceRepository;
        $this->interfaceProfileRepository = $interfaceProfileRepository;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $collection = $this->interfaceAttendanceRepository->query();
        if (@$request->keyword)
            $collection = $collection->searchByName($request->keyword);
        $collection = $collection->paginate($count);
        return AttendanceResource::collection($collection);
    }

    public function list_for_user(Request $request): AnonymousResourceCollection
    {
        $count = @$request->count ?? 10;
        $user = $this->interfaceProfileRepository->findById($request->user_id);
        $collection = $this->interfaceAttendanceRepository->query()->where('user_id','=',$user->id)->get();
        if (@$request->keyword)
            $collection = $collection->searchByName($request->keyword);
        $collection = $collection->paginate($count);
        return AttendanceResource::collection($collection);
    }

    public function list_for_me(Request $request)//: AnonymousResourceCollection
    {
        $user = auth::user();
        $collection = $this->interfaceAttendanceRepository->query()->where('user_id','=',$user->id);
        if (@$request->keyword)
            $collection = $collection->searchByName($request->keyword);

        $startDate = $request->start_at;//Carbon::now()->subMonth();
        $endDate = $request->end_at;//Carbon::now();
        $collection = $collection->whereBetween('created_at', [$startDate, $endDate]);
        $collection = $collection->orderByDesc('id')
            ->get();
        return AttendanceResource::collection($collection);
    }

    /***************
     * @param AttendanceRequest $request
     * @return JsonResponse
     */
    public function store(AttendanceRequest $request): JsonResponse
    {
        $data = $request->except(["_token"]);
        if ($this->interfaceAttendanceRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    /**************************
     * @param int $id
     * @return AttendanceResource
     */
    public function show(int $id): AttendanceResource
    {
        return AttendanceResource::make($this->interfaceAttendanceRepository->findById($id));
    }

    /**
     * Update the specified resource in storage.
     * @param AttendanceRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, AttendanceRequest $request): JsonResponse
    {
        $data = $request->except(['_token']);
        if ($this->interfaceAttendanceRepository->updateItem($id, $data))
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
        if ($this->interfaceAttendanceRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد','status'=>false], HTTPResponse::HTTP_BAD_REQUEST);
    }
}

