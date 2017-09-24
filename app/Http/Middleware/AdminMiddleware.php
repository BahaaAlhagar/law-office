<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        $user = \Auth::user();
        
        if (!$user->isAdmin())
        {
            \Auth::logout();
            session()->flush();
            return redirect('/');
        }

        return $next($request);
    }
}
