<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use URL;

class VideoController extends Controller
{
    // This method will generate our secure URL
    public function find ($secret){
        return response()->json([
            // We specify which route should this method send the secure URL to
            'url' => URL::temporarySignedRoute('video_secret',
                // I have chosen that the link should expire in 5 seconds
                now()->addSeconds(5), ['secret' => $secret]
            )
        ],201);
    }

// This is the method which will send the secure URL to the user
    public function playVideoWithSecret ($secret){
        // Because '&&' used as the separator in the query string
        $secrets = explode("&&", $secret);
        $video_id = $secrets[0];
        $user_id = $secrets[1];

        $user = User::where('id',$user_id)->firstOrFail();
        // I ran some tests with $user, basically, has he the right to get the link? etc...

        $video = Video::where('id', $video_id)->first();

        return response()->file(  storage_path('app/Videos/') . $video->title . '.mp4');
    }
}
