<?php

namespace App\Http\Controllers;

use App\SmsLog;
use App\Conference;
use App\EmailLog;

class LogController extends Controller
{
    public function video()
    {
        $conferences = Conference::withCount('participants')->latest()->paginate(25);

        return view('logs.video')->withConferences($conferences);
    }

    public function sms()
    {
        $messages = SmsLog::latest()->paginate(25);

        return view('logs.sms')->withMessages($messages);
    }

    public function email()
    {
        $emails = EmailLog::latest()->paginate(25);

        return view('logs.email')->withEmails($emails);
    }

}
