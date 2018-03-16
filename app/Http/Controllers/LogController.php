<?php

namespace App\Http\Controllers;

use App\SmsLog;
use Yajra\Datatables\Datatables;

class LogController extends Controller
{
    public function sms()
    {
        return view('logs.sms');
    }

    public function smsData()
    {
        return Datatables::of(SmsLog::query())->make(true);
    }
}
