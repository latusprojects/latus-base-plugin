<?php

namespace Latus\BasePlugin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VerifyUserCanViewAdminModule
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        Gate::authorize('view-admin-module');

        return $next($request);
    }
}