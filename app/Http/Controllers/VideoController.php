<?php

namespace App\Http\Controllers;

use App\Service;
use App\Services\Twilio;

class VideoController extends Controller
{
    public function authenticate()
    {
        if (! Service::video()->active) {
            return response('The service has temporarily been stopped.', 503);
        }

        $identity = request()->has('identity') ? request('identity') : str_random(5);
        $room = request('room');

        $record = (request('record')) ?: false;

        $twilio = $this->setTwilio($room);
        $twilio->setIdentity($identity);
        $twilio->createRoom($record);
        $twilio->generateToken();

        return response()->json([
            'user_id' => request()->user()->id,
            'identity' => $identity,
            'jwt' => $twilio->getVideoToken()
        ]);
    }

    public function setTwilio($room)
    {
        return new Twilio(
            request('accessToken')->config['video']['params']['twilio_video_account_sid'],
            request('accessToken')->config['video']['params']['twilio_video_auth_token'],
            request('accessToken')->config['video']['params']['twilio_video_api_key'],
            request('accessToken')->config['video']['params']['twilio_video_api_secret'],
            $room
        );
    }
}
