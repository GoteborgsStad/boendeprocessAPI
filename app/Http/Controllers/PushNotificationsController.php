<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PushNotificationsController extends Controller
{
    public function testToMe()
    {
        $notification = new \App\Notification([
            'scheduledTime' => true,
            'title'         => 'Test title',
            'body'          => 'Test body',
            'ticker'        => 1,
            'redirect_to'   => 'redirect_to_this_page',
            'image_url'     => 'test_image.png',
            'audio_url'     => 'test_audio.wav',
        ]);

        $responses = $notification->send(\Auth::user(), 'Sambuh');

        return response()->json($responses, 200);
    }
}
