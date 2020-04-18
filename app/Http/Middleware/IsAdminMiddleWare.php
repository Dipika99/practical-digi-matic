<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class IsAdminMiddleWare
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
        if (Auth::user()->isRole('admin')) {
            return $next($request);
        }
        abort(403);
    }
}
