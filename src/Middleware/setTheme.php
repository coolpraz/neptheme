<?php

namespace Coolpraz\NepTheme\Middleware;

use Closure;

class setTheme
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $themeName)
    {
        np_theme()->set($themeName);
        return $next($request);
    }
}
