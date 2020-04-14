<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$role)
    {   
        // dd($request->user()->role == 'admin');
        if($request->user()->role == 'admin'){
            return $next($request);
        }
        else{
            return redirect()->route('home')->with('status','You are not allowed to access Admin Panel!');
        }
    }
}
