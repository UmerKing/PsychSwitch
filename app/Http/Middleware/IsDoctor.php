<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class IsDoctor
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
        if(auth()->user()->type === User::DOCTOR_TYPE) {
            return $next($request);
        }
        return redirect('home');
    }
}
