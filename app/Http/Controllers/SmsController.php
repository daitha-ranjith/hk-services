<?php

namespace App\Http\Controllers;

use App\Token;
use App\SmsLog;
use App\Service;
use Carbon\Carbon;
use App\Jobs\SendSms;

class SmsController extends Controller
{
    public function send()
    {
        // validate the request
        if (! request()->has('phone') ||
            ! request()->has('from') ||
            ! request()->has('message')
        ) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid parameters.'
            ]);
        }

        // get the token from the request
        $token = Token::getByToken(request('access_token'));

        // check for its status
        $sms   = $token['config']['sms'];

        if (! $sms['active']) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Service currently not active.'
            ]);
        }

        $data = [
            'sms' => $sms,
            'token' => $token,
            'phone'  => request('phone'),
            'from' => request('from'),
            'message' => request('message')
        ];

        // push to queue
        dispatch(new SendSms($data));

        // return json
        return response()->json([
            'status' => 'queued',
            'message' => 'Request received.'
        ]);
    }

    public function statusUpdate()
    {
        $sid = request('MessageSid');
        $status = request('MessageStatus');

        $record = SmsLog::where('sid', $sid)->first();

        if (! $record) {
            return response()->json(['status' => false, 'message' => 'No record found.'], 404);
        }

        $record->status = $status;
        if ($status == 'sent') {
            $record->sent_at = Carbon::now();
        }
        if ($status == 'delivered') {
            $record->delivered_at = Carbon::now();
        }

        $record->save();

        return response()->json(['status' => true, 'message' => 'Successfully updated.']);
    }

}
