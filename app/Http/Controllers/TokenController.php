<?php

namespace App\Http\Controllers;

class TokenController extends Controller
{
    public function update()
    {
        return null;
    }

    public function resetApiToken()
    {
        $user = request()->user();
        $user->api_token = str_random(60);
        $user->save();

        return redirect()->back()->withStatus('API token has been successfully generated!');
    }

}
