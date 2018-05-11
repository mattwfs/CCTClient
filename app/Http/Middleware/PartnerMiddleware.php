<?php

namespace App\Http\Middleware;

use Closure;

class PartnerMiddleware
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
        
        if (! \Auth::check()){
            return redirect('login');
        }
        else{
            if(! auth()->user()->is_partner){
                
                return redirect('not-authorized');
            }
        }
        return $next($request);
    }
}