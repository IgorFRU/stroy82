<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

use Carbon\Carbon;

class UserOnline
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
        if (Auth::user()) {
            $user = Auth::user();
            $now = Carbon::now();
            $user->last_activity = $now;
            $user->save();
        }
        return $next($request);
    }
}
