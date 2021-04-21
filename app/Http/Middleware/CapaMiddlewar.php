<?php

namespace App\Http\Middleware;

use Closure;

class CapaMiddlewar
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
        if (auth()->check() && auth()->user()->is_capa or auth()->check() && auth()->user()->is_admin)
            return $next($request);
        return redirect('/SinAcceso');

    }
}
