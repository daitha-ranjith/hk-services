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
                    'twilio_account_sid' => 'required',
                    'twilio_api_key'     => 'required',
                    'twilio_api_secret'  => 'required'
                ];

                $config['video'] = [
                    'active' => true,
                    'params' => [
                        'twilio_account_sid' => request()->twilio_account_sid,
                        'twilio_api_key'     => request()->twilio_api_key,
                        'twilio_api_secret'  => request()->twilio_api_secret
                    ]
                ];
            } else {
                $config['video'] = [
                    'active' => false
                ];
            }

            $account->config = $config;
        }

        request()->validate($validations);

        $account->save();

        return redirect()->back()->withStatus('Account details have been changed.');
    }

}
