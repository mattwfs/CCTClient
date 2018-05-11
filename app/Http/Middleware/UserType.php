<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$user_type)
    {
        if (! Auth::check()){
            return redirect('login');
        }
        else{
            if(auth()->user()->user_type != $user_type)
                {
                return redirect('not-authorized');
                }   
        }

        return $next($request);
    }
}
