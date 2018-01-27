<?php

namespace App\Http\Controllers;

use App\Token;
use App\Jobs\SendEmail;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function send()
    {
        // validate the request
        if (! request()->has('sender_email') ||
            ! request()->has('sender_name') ||
            ! request()->has('to') ||
            ! request()->has('subject') ||
            ! request()->has('content')
        ) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid parameters.'
            ]);
        }

        // get the token from the request
        $token = Token::getByToken(request('access_token'));

        // check for its status
        $email   = $token['config']['email'];

        if (! $email['active']) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Service currently not active.'
            ]);
        }

        $data = [
            'email' => $email,
            'token' => $token->toArray(),
            'subject' => request('subject'),
            'sender_email' => request('sender_email'),
            'sender_name' => request('sender_name'),
            'to'  => request('to'),
            'cc'  => request('cc'),
            'bcc' => request('bcc'),
            'content' => request('content')
        ];

        // push to queue
        dispatch(new SendEmail($data));

        // return json
        return response()->json([
            'status' => 'queued',
            'message' => 'Request received.'
        ]);
    }

}
