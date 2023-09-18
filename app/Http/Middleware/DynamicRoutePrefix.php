<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DynamicRoutePrefix
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->hasAnyRole(['super admin', 'admin'])) {
            // If the user has the 'admin' role, set the prefix to 'admin'
            $request->attributes->set('dynamic_prefix', 'admin');
        } else {
            // Set a default prefix for other users
            $request->attributes->set('dynamic_prefix', 'user');
        }

        return $next($request);
    }
}
