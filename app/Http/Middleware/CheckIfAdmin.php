<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $adminEmail = config('app.admin_email');

        if ($request->user() && $request->user()->email === $adminEmail) {
            return $next($request);
        }

        return response('Not Found', 404);
    }
}
