<?php

namespace App\Http\Controllers;

use App\Token;

class TokenController extends Controller
{
    public function update($id)
    {
        $token = Token::findOrFail($id);

        return redirect()->back()->withStatus('Changes successfully saved');
    }

    public function resetApiToken()
    {
        $token = Token::findOrFail(request()->id);
        $token->access_token = str_random(60);
        $token->save();

        return redirect()->back()->withStatus('API token has been successfully generated!');
    }

}
