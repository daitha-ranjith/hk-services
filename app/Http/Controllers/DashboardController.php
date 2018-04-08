<?php

namespace App\Http\Controllers;

use Charts;
use App\Conference;
use App\Participant;
use App\SmsLog;
use App\EmailLog;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $videoChart = Charts::multi('bar', 'highcharts')
        //     ->title("Video Conferences")
        //     ->elementLabel('Count')
        //     ->dataset('Conferences', [5, 20])
        //     ->dataset('Participants', [15, 30])
        //     ->labels(['8 Apr', '9 Apr']);

        $videoChart = Charts::multiDatabase('bar', 'highcharts')
                            ->title('Video Stats')
                            ->dataset('Conferences', Conference::all())
                            ->dataset('Participants', Participant::all())
                            ->elementLabel("Monthly Count")
                            ->responsive(true)
                            ->lastByMonth(6, true);

        $smsChart = Charts::database(SmsLog::all(), 'area', 'highcharts')
                            ->title('SMS Stats')
                            ->elementLabel("SMS per month")
                            ->responsive(true)
                            ->lastByMonth(3, true);

        $emailChart = Charts::database(EmailLog::all(), 'line', 'highcharts')
                            ->title('Email Stats')
                            ->elementLabel("Emails per month")
                            ->responsive(true)
                            ->lastByMonth(3, true);

        return view('dashboard', compact('videoChart', 'smsChart', 'emailChart'));
    }
}
