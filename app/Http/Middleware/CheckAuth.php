<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class checkAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $auths = null)
    {
        if (Auth::User()->checkAuth($auths)) {
            return $next($request); 
        }
        return redirect()->route('home');
    }
}
