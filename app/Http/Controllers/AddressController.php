<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\address\AddressRequest;
use App\Http\Resources\city\CityResource;
use App\Models\City;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Log;

/**
 * @group Address
 *
 * API endpoints for Address Services
 *
 * @subgroupDescription برای دسترسی به بخش های Address موبایل از این طریق به اطلاعات دسترسی پیدا کنید
 */
class AddressController extends Controller
{
    public function geo_to_address(AddressRequest $request): CityResource|JsonResponse
    {
        try {
            $data = get_reverse_geo_to_address($request->lat, $request->lon);
            if (!@$data) {
                return response()->json(['message' => 'آدرس شما انتخابی شما صحیح نیست']);
            }
            $result = $data->original;
            sleep(1);
            $city = City::whereName($result->city)->firstOrFail();
            return new CityResource($city);
        } catch (Exception $ex) {
            Log::error($ex);
            return response()->json(['message' => 'خطایی رخ داده است ، لطفا با مدیریت تماس حاصل فرمایید']);
        }
    }
}
