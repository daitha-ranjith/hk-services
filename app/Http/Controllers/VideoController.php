<?php

namespace App\Http\Controllers;

use App\Services\Twilio;

class VideoController extends Controller
{
    public function authenticate()
    {
        $identity = request()->has('identity') ? request('identity') : str_random(5);
        $room = request('room');

        $twilio = $this->setTwilio();
        $twilio->setIdentity($identity);
        $twilio->generateToken();

        return response()->json([
            'user_id' => request()->user()->id,
            'identity' => $identity,
            'jwt' => $twilio->getVideoToken($room)
        ]);
    }

    public function setTwilio()
    {
        return new Twilio(
            request('accessToken')->config['video']['params']['twilio_video_account_sid'],
            request('accessToken')->config['video']['params']['twilio_video_api_key'],
            request('accessToken')->config['video']['params']['twilio_video_api_secret']
        );
    }
}
