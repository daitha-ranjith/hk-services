<?php

namespace App\Http\Controllers;

use App\Services\Twilio;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function authenticate()
    {
        return request()->token;

        $identity = request()->has('identity') ? request()->identity : str_random(5);

        $twilio = $this->setTwilio();
        $twilio->setIdentity($identity);
        $twilio->generateToken();

        return response()->json([
            'user_id' => request()->user()->id,
            'jwt' => $twilio->getVideoToken()
        ]);
    }

    public function setTwilio()
    {
        return new Twilio('ACe4f94175c64ccfc9b1266ce7759aac1f', 'SKf971fcbf55740881e7e3fb0f5349c09a', 'hyNsLKbzsMZvHWvSBUNc6WSRvyGsWoEn');
    }
}