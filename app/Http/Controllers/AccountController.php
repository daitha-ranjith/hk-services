<?php

namespace App\Http\Controllers;

use App\User;
use App\Token;
use App\UserDetail;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $accounts = User::paginate(10);

        return view('users.index')->withAccounts($accounts);
    }

    public function create()
    {
        return view('auth.register');
    }

    public function createSubAccount($accountId)
    {
        return view('accounts.create')->with(compact('accountId'));
    }

    public function editSubAccount($accountId, $subAccountId)
    {
        $subAccount = Token::findOrFail($subAccountId);

        return view('accounts.edit')->with(compact('accountId', 'subAccount'));
    }

    public function updateSubAccount($accountId, $subAccountId)
    {
        $account = Token::findOrFail($subAccountId);

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
                    'twilio_video_auth_token'  => 'required',
                    'twilio_video_api_key'     => 'required',
                    'twilio_video_api_secret'  => 'required'
                ];

                $config['video'] = [
                    'active' => true,
                    'params' => [
                        'twilio_video_account_sid' => request()->twilio_video_account_sid,
                        'twilio_video_auth_token'  => request()->twilio_video_auth_token,
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

    public function storeSubAccount($accountId)
    {
        $token = new Token;
        $token->user_id = $accountId;
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
        $account = User::findOrFail($id);

        $subAccounts = Token::where('user_id', $account->id)->paginate(5);

        return view('users.edit')->with(compact('account', 'subAccounts'));
    }

    public function update($id)
    {
        $validations = [];

        if (request('name')) $validations['name'] = 'string|max:255';
        if (request('email')) $validations['email'] = 'string|email|max:255|unique:users,email,'.$id;
        if (request('mobile_no')) $validations['mobile_no'] = 'digits_between:9,11';
        if (request('password')) $validations['password'] = 'string|min:6|confirmed';
        if (request('address')) $validations['address'] = 'string';

        request()->validate($validations);

        $account = User::findOrFail($id);
        if (request('name')) $account->name = request('name');
        if (request('email')) $account->email = request('email');
        if (request('password')) $account->password = bcrypt('password');

        $details = UserDetail::where('user_id', $account->id)->first();
        if (request('mobile_no')) $details->mobile_no = request('mobile_no');
        if (request('address')) $details->address = request('address');

        $account->save();
        $details->save();

        return redirect()->back()->withStatus('Account details have been changed.');
    }

}
