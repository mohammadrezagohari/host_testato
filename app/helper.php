<?php

use App\Models\Question;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use NumberToWords\NumberToWords;

if (!function_exists("custom_pagination")) {
    /******************************************************
     * create a customized pagination for laravel
     *
     * @param mixed $models
     * your selected collection or model
     *
     * @param int $perPage
     * count of per page items
     *
     * @param int $page [optional]
     * you can set your page index with this
     * if it hasn't values, show first page
     * @param int $options [optional]
     * you can set others options in this item
     *
     * @return LengthAwarePaginator
     * it's send our pagination
     */
    function custom_pagination($models, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ? $page : (Paginator::resolveCurrentPage() ? Paginator::resolveCurrentPage() : 1);
        $models = $models instanceof Collection ? $models : Collection::make($models);
        return new LengthAwarePaginator($models->forPage($page, $perPage), $models->count(), $perPage, $page, $options);
    }
}

if (!function_exists("expire_date")) {
    /*********************************
     * set expire at after minutes
     * @param int $minutes [optional]
     ********************************/

    function expire_date(int $minutes = 2)
    {

        return Carbon::createFromFormat('Y-m-d H:i:s', now())->addMinutes($minutes)->toDateTime();
    }
}

if (!function_exists("random_otp_generator")) {
    /*********************************
     * get random code
     * @return int
     ********************************/
    function random_otp_generator(): int
    {
        return rand(1000, 9999);
    }
}

if (!function_exists("get_current_date_time")) {
    /*********************************
     * get random code
     ********************************/
    function get_current_date_time()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', now())->toDateTime();
    }
}

if (!function_exists("otp_generator")) {
    /*********************************
     * get random code
     ********************************/
    function otp_generator(\App\Models\User $user): Model
    {
        return $user->UserOTPs()->create([
            'otp' => random_otp_generator(),
            'expire_at' => expire_date(5)
        ]);
    }
}

if (!function_exists("upload_asset_file")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function upload_asset_file($file): string
    {
        $fileName = time() . '-' . rand(1001, 9999) . '.' . $file->extension();
        return $file->storeAs('assets/icon', $fileName, 'public');
//        $fileName = time() . '.' . $file->extension();
//        $prefix_asset = 'assets/icon';
//        $file->move(public_path($prefix_asset), $fileName);
//        return "{$prefix_asset}/{$fileName}";
    }
}
if (!function_exists("upload_story_file")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function upload_story_file($file): string
    {
        $fileName = rand(10000, 999999999) . '.' . $file->extension();
        return $file->storeAs('uploads/story/', $fileName, 'public');
//        $fileName = time() . '.' . $file->extension();
//        $prefix_asset = 'upload/story';
//        $file->move(public_path($prefix_asset), $fileName);
//        return "{$prefix_asset}/{$fileName}";

    }
}
if (!function_exists("upload_slider_file")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function upload_slider_file($file): string
    {
        $fileName = time() . '-' . rand(1001, 9999) . '.' . $file->extension();
        return $file->storeAs('upload/slider', $fileName, 'public');

//        $fileName = time() . '.' . $file->extension();
//        $prefix_asset = 'upload/slider';
//        $file->move(public_path($prefix_asset), $fileName);
//        return "{$prefix_asset}/{$fileName}";

    }
}

if (!function_exists("upload_asset_background_file")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function upload_asset_background_file($file): string
    {
        $fileName = time() . '-' . rand(1001, 9999) . '.' . $file->extension();
        return $file->storeAs('assets/background', $fileName, 'public');

//        $fileName = time() . '.' . $file->extension();
//        $prefix_asset = 'assets/background';
//        $file->move(public_path($prefix_asset), $fileName);
//        return "{$prefix_asset}/{$fileName}";

    }
}

if (!function_exists("upload_video_file")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function upload_video_file($file): string
    {
        $fileName = time() . '-' . rand(1001, 9999) . '.' . $file->extension();
        return $file->storeAs('videos/answer_sheet', $fileName, 'public');

//        $fileName = time() . '.' . $file->extension();
//        $prefix_asset = 'videos/answer_sheet';
//        $file->move(public_path($prefix_asset), $fileName);
//        return "{$prefix_asset}/{$fileName}";
    }
}

if (!function_exists("upload_ads_video")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function upload_ads_video($file): string
    {
        $fileName = time() . '-' . rand(1001, 9999) . '.' . $file->extension();
        return $file->storeAs('videos/ads', $fileName, 'public');
//        $fileName = time() . '.' . $file->extension();
//        $prefix_asset = 'videos/ads';
//        $file->move(public_path($prefix_asset), $fileName);
//        return "{$prefix_asset}/{$fileName}";
    }
}

if (!function_exists("upload_unit_image")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function upload_unit_image($file): string
    {
        $fileName = time() . '-' . rand(1001, 9999) . '.' . $file->extension();
        return $file->storeAs('uploads/units', $fileName, 'public');
    }
}

if (!function_exists("upload_unit_exercise_image")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function upload_unit_exercise_image($file): string
    {
        $fileName = time() . '-' . rand(1001, 9999) . '.' . $file->extension();
        return $file->storeAs('uploads/unit_exercise', $fileName, 'public');

//        $fileName = time() . '-' . rand(1, 5000) . '.' . $file->extension();
//        $prefix_asset = 'uploads/unit_exercise';
//        $file->move(public_path($prefix_asset), $fileName);
//        return "{$prefix_asset}/{$fileName}";
    }
}
if (!function_exists("upload_question_image")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function upload_question_image($file): string
    {
        $fileName = time() . '-' . rand(1001, 9999) . '.' . $file->extension();
        return $file->storeAs('uploads/questions/images', $fileName, 'public');
//        $fileName = time() . '-' . rand(1, 5000) . '.' . $file->extension();
//        $prefix_asset = 'uploads/questions/images';
//        $file->move(public_path($prefix_asset), $fileName);
//        return "{$prefix_asset}/{$fileName}";
    }
}
if (!function_exists("upload_question_video")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function upload_question_video($file): string
    {
        $fileName = time() . '-' . rand(1001, 9999) . '.' . $file->extension();
        return $file->storeAs('uploads/questions/videos', $fileName, 'public');

//        $fileName = time() . '-' . rand(1, 5000) . '.' . $file->extension();
//        $prefix_asset = 'uploads/questions/videos';
//        $file->move(public_path($prefix_asset), $fileName);
//        return "{$prefix_asset}/{$fileName}";
    }
}


if (!function_exists("upload_data")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function upload_data($file, $title = null)
    {
        if (@$title) {
            $title = str_replace(' ', '', $title);
            $fileName = $title . '-' . rand(1001, 9999) . '.' . $file->extension();
            return $file->storeAs('uploads/data', $fileName, 'public');
//            $title = str_replace(' ', '', $title);
//            $fileName = $title . '-' . rand(1, 5000) . '.' . $file->extension();
//            return $file->storeAs('uploads', $fileName, 'public');
        } else {
            $fileName = time() . '-' . rand(1001, 9999) . '.' . $file->extension();
            return $file->storeAs('uploads/data', $fileName, 'public');
        }
    }
}

if (!function_exists("download_data")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function download_data($file)
    {
        if (@$file) {
            return Storage::disk('public')->url($file);
        } else {
            return "";
        }
    }
}

if (!function_exists("delete_data_upload")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function delete_data_upload($path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists("kavenegar_verification")) {
    /*********************************
     * send kavenegar sms
     ********************************/
    function kavenegar_verification($receptor, $token, $token2 = null, $token3 = null): mixed
    {
        $APIKEY = env('KAVENEGAR_API_KEY');
        $baseUrl = "https://api.kavenegar.com/v1/{$APIKEY}/verify/lookup.json";
        return Http::get($baseUrl, [
            'receptor' => $receptor,
            'token' => $token,
            'token2' => $token2,
            'token3' => $token3,
            'template' => env('KAVEHNEGAR_OTP_NAME'),
            'type' => 'sms'
        ]);
    }
}

if (!function_exists("get_reverse_geo_to_address")) {
    /*********************************
     * reverse geo location to address
     ********************************/
    function get_reverse_geo_to_address($latitude, $longitude)
    {
        $client = new Client();
        $url = "https://map.ir/reverse";
        $response = $client->request('GET', $url, [
            'query' => [
                'lat' => $latitude,
                'lon' => $longitude
            ],
            'headers' => [
                'x-api-key' => env('MAP_IR_API_KEY')
            ]
        ]);
        $data = json_decode($response->getBody()->getContents());
        return response()->json($data);
    }
}

if (!function_exists("get_reverse_geo_to_address")) {
    /*********************************
     * reverse geo location to address
     ********************************/
    function get_reverse_geo_to_address($latitude, $longitude)
    {
        $client = new Client();
        $url = "https://map.ir/reverse";
        $response = $client->request('GET', $url, [
            'query' => [
                'lat' => $latitude,
                'lon' => $longitude
            ],
            'headers' => [
                'x-api-key' => env('MAP_IR_API_KEY')
            ]
        ]);
        $data = json_decode($response->getBody()->getContents());
        return response()->json($data);
    }
}

if (!function_exists("question_name_generator")) {
    /*********************************
     * reverse geo location to address
     ********************************/
    function question_name_generator($unit, $level)
    {
        $questionCount = Question::whereLevelId($level->id)->count();
        $id = null;
        if ($questionCount == 0)
            $id = NumberToWords::transformNumber('fa', 1);
        else
            $id = NumberToWords::transformNumber('fa', ($questionCount + 1));

        return "سوال {$unit->title}  {$level->title} {$id}";
    }
}

if (!function_exists("find_and_get_string")) {
    /*********************************
     * reverse geo location to address
     ********************************/
    function find_and_get_string($string, $search)
    {
        $position = strpos($string, $search);
        return substr($string, $position + 1, 1);
    }
}


if (!function_exists("send_notification_FCM")) {
    function send_notification_FCM($notification_id, $title, $message, $id,$type) {
        $accesstoken = env('FCM_KEY');
        $URL = 'https://fcm.googleapis.com/fcm/send';
        $post_data = '{
            "to" : "' . $notification_id . '",
            "data" : {
              "body" : "",
              "title" : "' . $title . '",
              "type" : "' . $type . '",
              "id" : "' . $id . '",
              "message" : "' . $message . '",
            },
            "notification" : {
                 "body" : "' . $message . '",
                 "title" : "' . $title . '",
                  "type" : "' . $type . '",
                 "id" : "' . $id . '",
                 "message" : "' . $message . '",
                "icon" : "new",
                "sound" : "default"
                },

          }';
        // print_r($post_data);die;

        $crl = curl_init();

        $headr = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: ' . $accesstoken;
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($crl, CURLOPT_URL, $URL);
        curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);

        curl_setopt($crl, CURLOPT_POST, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);

        $rest = curl_exec($crl);

        if ($rest === false) {
            // throw new Exception('Curl error: ' . curl_error($crl));
            //print_r('Curl error: ' . curl_error($crl));
            $result_noti = 0;
        } else {

            $result_noti = 1;
        }

        //curl_close($crl);
        //print_r($result_noti);die;
        return $result_noti;
    }
}


