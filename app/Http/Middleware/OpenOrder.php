<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

use Carbon\Carbon;

class OpenOrder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $order)
    {
        if (Auth::check()) {
            if ($order->user_id != Auth::user()->id) {
                
            }
        } else {
            if (!$request->session()->has('order') || session('order') != $number) {
                abort(403, 'Unauthorized action.');
            }
        } 
        
        return $next($request);
        
    }

    
}
