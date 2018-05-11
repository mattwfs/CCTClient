<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {

        if (! Auth::check()){
            return redirect('login');
        }
        else{
            if(auth()->user()->role_id != get_role_id($role))
            {
                return redirect('not-authorized');
            }   
        }

        return $next($request);
    }
}
