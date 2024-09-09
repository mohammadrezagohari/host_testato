<?php

namespace App\Http\Controllers;

use App\Http\Requests\version\VersionRequest;
use App\Http\Resources\province\ProvinceResource;
use App\Http\Resources\version\VersionResource;
use App\Repositories\MySQL\AttendanceRepository\InterfaceAttendanceRepository;
use App\Repositories\MySQL\VersionRepository\InterfaceVersionRepository;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Version
 *
 * API endpoints for Version control
 *
 * @subgroupDescription برای دسترسی به بخش های Version موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class VersionController extends Controller
{
    private InterfaceVersionRepository $interfaceVersionRepository;
    private InterfaceAttendanceRepository $interfaceAttendanceRepository;

    public function __construct(InterfaceVersionRepository $interfaceVersionRepository, InterfaceAttendanceRepository $interfaceAttendanceRepository)
    {
        $this->interfaceVersionRepository = $interfaceVersionRepository;
        $this->interfaceAttendanceRepository = $interfaceAttendanceRepository;
    }

    public function latest(Request $request)
    {
        if (auth::check()) {
            $this->interfaceAttendanceRepository->insertData([
                'user_id' => auth::user()->id
            ]);
        }
        $result['data'] = $this->interfaceVersionRepository->query()->whereIsData()->latest('id')->first();
        $result['app'] = $this->interfaceVersionRepository->query()->whereIsApp()->latest('id')->first();
        return response()->json($result, HTTPResponse::HTTP_OK);
    }

    public function latest_download()
    {
        $result = $this->interfaceVersionRepository->query()->whereIsApp()->latest('id')->first();
        $downloadLink = @$result->application_file ? download_data($result->application_file) : null;
        return response()->json(["link" => $downloadLink], HTTPResponse::HTTP_OK);
    }

    public function index(Request $request)
    {
        $count = @$request->count ?? 10;
        $collection = $this->interfaceVersionRepository->query()->paginate($count);
        return VersionResource::collection($collection);
    }

    public function store(VersionRequest $request): JsonResponse
    {
        $data = $request->except(["_token"]);
        if ($request->has('application_file')) {
            $data['application_file'] = upload_data($request->file('application_file'));
        }
        if ($this->interfaceVersionRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    public function store_version_file($id, Request $request): JsonResponse
    {
        if ($request->has('application_file')) {
            $data['application_file'] = upload_data($request->file('application_file'));
            if ($this->interfaceVersionRepository->updateItem($id, $data))
                return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        } else {
            return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
        }
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    public function show(int $id): VersionResource
    {
        return VersionResource::make($this->interfaceVersionRepository->findById($id));
    }

    public function update(int $id, VersionRequest $request): JsonResponse
    {
        $data = $request->except(["_token"]);
        if ($request->has('application_file')) {
            $data['application_file'] = upload_data($request->file('application_file'));
        }
        if ($this->interfaceVersionRepository->updateItem($id, $data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    public function destroy($id): JsonResponse
    {
        if ($this->interfaceVersionRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }

    public function Statistic()
    {
        return $this->interfaceVersionRepository->quantity();
    }
}
