<?php

namespace App\Http\Middleware;

use Closure;

class ActiveMiddleware
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
        if (! Auth::check()){
            return redirect('login');
        }
        else{
            if(auth()->user()->created_at == auth->user()->updated_at){
                return redirect('user');
            }   
        }
        
        return $next($request);
    }
}
