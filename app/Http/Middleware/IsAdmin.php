<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class IsAdmin
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
        $admin_email = env('ADMIN_EMAIL');

        if (Auth::user() && Auth::user()->email == $admin_email) {
            return $next($request);
        }

        return redirect('/login')->withErrors([
            'email' => 'You need to be an admin to view that content.'
        ]);
    }
}
