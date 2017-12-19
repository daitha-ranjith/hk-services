<?php

namespace App\Http\Controllers;

use App\Token;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = auth()->user()->accounts()->paginate(3);

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
            'chat' => ['active' => false],
            'sms' => ['active' => false],
            'email' => ['active' => false]
        ];
        $token->save();

        return redirect()->back()->withStatus('Account created and fresh access token has been generated automatically.');
    }

}
