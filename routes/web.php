<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
//    return "<h1>come to app</h1>";
    return view('home');
});



Route::get('send',function (){
    $user = \App\Models\User::first();
    $notification_id = $user->notification_id;
    $title = "Greeting Notification";
    $message = "Have good day!";
    $id = $user->id;
    $type = "basic";

    $res = send_notification_FCM($notification_id, $title, $message, $id,$type);

    if($res == 1){

        // success code

    }else{

        // fail code
    }

});

Route::get('payment',function (){
    $bank = new \App\Services\Bank\Melat\MelatBankPort();
    $res = $bank->paymentRequest(1000,1,["user_id"=>1],0);
    dd($res);
});

Route::group(['prefix'=>'bankport'],function (){
    Route::get('melat/callback',function (){
        $paymentResult="intent://testato.deeplink/payment/?status=success#Intent;package=ir.testato;scheme=https;end";
        header("Location: $paymentResult");
        exit;
    });
});


