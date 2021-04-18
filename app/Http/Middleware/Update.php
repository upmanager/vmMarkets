<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\InstallController;

class Update
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
        InstallController::update();
        return $next($request);
    }
}
