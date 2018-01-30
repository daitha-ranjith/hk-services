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
            return response()->json([
                'status' => false,
                'message' => 'The service has temporarily stopped.'
            ], 503);
        }

        $identity = request()->has('identity') ? request('identity') : str_random(5);

        $twilio = $this->setTwilio();
        $twilio->setIdentity($identity);
        $twilio->generateToken();

        $service_sid = request('accessToken')->config['chat']['params']['twilio_chat_service_sid'];

        return response()->json([
            'user_id' => request()->user()->id,
            'identity' => $identity,
            'jwt' => $twilio->getChatToken($service_sid)
        ]);
    }

    public function setTwilio()
    {
        return new Twilio(
            request('accessToken')->config['chat']['params']['twilio_chat_account_sid'],
            request('accessToken')->config['chat']['params']['twilio_chat_api_key'],
            request('accessToken')->config['chat']['params']['twilio_chat_api_secret']
        );
    }
}
