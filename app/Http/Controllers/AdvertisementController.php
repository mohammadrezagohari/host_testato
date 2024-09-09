<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\advertisement\AdvertisementRequest;
use App\Http\Resources\advertisement\AdvertisementResource;
use App\Repositories\MySQL\AdvertisementRepository\InterfaceAdvertisementRepository;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group Advertisement
 *
 * API endpoints for Advertisement
 *
 * @subgroupDescription برای دسترسی به بخش های Advertisement موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class AdvertisementController extends Controller
{
    private InterfaceAdvertisementRepository $interfaceAdvertisementRepository;

    public function __construct(InterfaceAdvertisementRepository $interfaceAdvertisementRepository)
    {
        $this->interfaceAdvertisementRepository = $interfaceAdvertisementRepository;
    }

    public function index(Request $request)
    {
        return AdvertisementResource::collection(
            $this->interfaceAdvertisementRepository
                ->query()->withIndex()->paginate());
    }


    public function list(Request $request)
    {
        return AdvertisementResource::collection(
            $this->interfaceAdvertisementRepository
                ->query()->withIndex()->paginate($request->count));
    }


    public function show_random()
    {
        return AdvertisementResource::make($this->interfaceAdvertisementRepository->query()->where('expire_at', '<', now())->inRandomOrder()->first());
    }

    public function store(AdvertisementRequest $request)
    {


        $data = $request->except(["_token"]);
        if (@$request->video_link) {
            $data["video_link"] = upload_video_file($request->video_link);
        }
        if (@$request->paid_status) {
            $data["paid_status"] = $request->paid_status == "true" ? 1 : 0;
        }
        if (@$request->expire_at) {
            $currentDate = \verta($request->expire_at)->toCarbon();
            [$year,$month,$day]= Verta::jalaliToGregorian($currentDate->year, $currentDate->month, $currentDate->day);
            $data["expire_at"] = "{$year}-{$month}-{$day}";
        }
        $data['user_id'] = \Auth::user()->id;
        if (@$this->interfaceAdvertisementRepository->insertData($data))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }
    
    public function destroy($id)
    {
        if (@$this->interfaceAdvertisementRepository->deleteData($id))
            return response()->json(['message' => 'عملیات موفقیت آمیز بود', 'status' => true], HTTPResponse::HTTP_OK);
        return response()->json(['message' => 'متاسفانه! خطایی رخ داد', 'status' => false], HTTPResponse::HTTP_BAD_REQUEST);
    }
}
