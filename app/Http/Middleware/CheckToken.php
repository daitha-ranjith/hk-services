<?php

namespace App\Http\Middleware;

use Closure;
use App\Token;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! cache()->has($request->token)) {
            return response()->json([
                'message' => 'Unauthorized access.'
            ], 401);
        }

        $access_token = cache()->get($request->token);

        $token = Token::getByToken($access_token);

        $request->request->add(['accessToken' => $token]);

        return $next($request);
    }
}
