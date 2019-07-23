<?php

namespace App\Http\Middleware;

use Closure;

class CheckUrlLoginToken
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

        // dd($request->route('token'));
        // dd($request, $token);
        
        // if ($request->route('token') == env('LOGIN_URL_TOKEN')) {
        //     return $next($request);
        // } else {
        //     return redirect('/');
        // }
        
        // if (request()->token == env('LOGIN_URL_TOKEN')) {
            
        if (request()->token == '123') {
            return $next($request);
        } else {
            return redirect('/');
        }

        
    }
}
