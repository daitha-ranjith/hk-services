<?php

namespace App\Http\Controllers;

use App\SmsLog;
use App\Conference;

class LogController extends Controller
{
    public function video()
    {
        $conferences = Conference::withCount('participants')->paginate(10);

        return view('logs.video')->withConferences($conferences);
    }

    public function sms()
    {
        return view('logs.sms');
    }

    public function email()
    {
        return view('logs.email');
    }

}
