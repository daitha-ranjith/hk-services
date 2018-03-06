<?php

namespace App\Http\Controllers;

use App\Service;
use App\Services\Twilio;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;

class ChatController extends Controller
{
    public function authenticate()
    {
        if (! Service::chat()->active) {
            return response('The service has temporarily been stopped.', 503);
        }

        $identity = request()->has('identity') ? request('identity') : str_random(5);
        $room = request('room');

        $twilio = $this->setTwilio($room);
        $twilio->setIdentity($identity);
        $twilio->generateToken();

        $service_sid = request('accessToken')->config['chat']['params']['twilio_chat_service_sid'];

        return response()->json([
            'user_id' => request()->user()->id,
            'identity' => $identity,
            'jwt' => $twilio->getChatToken($service_sid)
        ]);
    }

    public function setTwilio($room)
    {
        return new Twilio(
            request('accessToken')->config['chat']['params']['twilio_chat_account_sid'],
            null,
            request('accessToken')->config['chat']['params']['twilio_chat_api_key'],
            request('accessToken')->config['chat']['params']['twilio_chat_api_secret'],
            $room,
            request('accessToken')->user_id
        );
    }
}
