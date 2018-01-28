<?php

namespace App\Http\Controllers;

use App\Token;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = auth()->user()->accounts()->paginate(10);

        return view('accounts.index')->withAccounts($accounts);
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Token $token)
    {
        $token->user_id = auth()->id();
        $token->access_token = str_random(60);
        $token->label = request()->label;
        $token->config = [
            'video' => ['active' => false],
            'chat'  => ['active' => false],
            'sms'   => ['active' => false],
            'email' => ['active' => false]
        ];
        $token->save();

        return redirect()->back()->withStatus('Account created and fresh access token has been generated automatically.');
    }

    public function edit($id)
    {
        $account = Token::findOrFail($id);

        return view('accounts.edit')->withAccount($account);
    }

    public function update($id)
    {
        $account = Token::findOrFail($id);

        $config = $account->config;

        $validations = [];

        if (request()->section == 'label') {
            $validations = [
                'label' => 'required'
            ];

            $account->label = request()->label;
        }

        if (request()->section == 'twilio-video') {
            if (request()->twilio_video) {
                $validations = [
                    'twilio_video_account_sid' => 'required',
                    'twilio_video_api_key'     => 'required',
                    'twilio_video_api_secret'  => 'required'
                ];

                $config['video'] = [
                    'active' => true,
                    'params' => [
                        'twilio_video_account_sid' => request()->twilio_video_account_sid,
                        'twilio_video_api_key'     => request()->twilio_video_api_key,
                        'twilio_video_api_secret'  => request()->twilio_video_api_secret
                    ]
                ];
            } else {
                $config['video'] = [
                    'active' => false
                ];
            }
        }

        if (request()->section == 'twilio-chat') {
            if (request()->twilio_chat) {
                $validations = [
                    'twilio_chat_account_sid' => 'required',
                    'twilio_chat_api_key'     => 'required',
                    'twilio_chat_api_secret'  => 'required',
                    'twilio_chat_service_sid' => 'required'
                ];

                $config['chat'] = [
                    'active' => true,
                    'params' => [
                        'twilio_chat_account_sid' => request()->twilio_chat_account_sid,
                        'twilio_chat_api_key'     => request()->twilio_chat_api_key,
                        'twilio_chat_api_secret'  => request()->twilio_chat_api_secret,
                        'twilio_chat_service_sid' => request()->twilio_chat_service_sid
                    ]
                ];
            } else {
                $config['chat'] = [
                    'active' => false
                ];
            }
        }

        if (request()->section == 'twilio-sms') {
            if (request()->twilio_sms) {
                $validations = [
                    'twilio_sms_account_sid' => 'required',
                    'twilio_sms_auth_token'    => 'required'
                ];

                $config['sms'] = [
                    'active' => true,
                    'params' => [
                        'twilio_sms_account_sid' => request()->twilio_sms_account_sid,
                        'twilio_sms_auth_token'    => request()->twilio_sms_auth_token
                    ]
                ];
            } else {
                $config['sms'] = [
                    'active' => false
                ];
            }
        }

        if (request()->section == 'email') {
            if (request()->email) {
                $validations = [
                    'email_smtp_host'     => 'required',
                    'email_smtp_port'     => 'required',
                    'email_smtp_username' => 'required',
                    'email_smtp_password' => 'required'
                ];

                $config['email'] = [
                    'active' => true,
                    'params' => [
                        'email_smtp_host'     => request()->email_smtp_host,
                        'email_smtp_port'     => request()->email_smtp_port,
                        'email_smtp_username' => request()->email_smtp_username,
                        'email_smtp_password' => request()->email_smtp_password
                    ]
                ];
            } else {
                $config['email'] = [
                    'active' => false
                ];
            }
        }

        $account->config = $config;

        request()->validate($validations);

        $account->save();

        return redirect()->back()->withStatus('Account details have been changed.');
    }

}
