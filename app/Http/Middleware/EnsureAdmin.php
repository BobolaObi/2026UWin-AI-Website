<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        if ($user->is_admin) {
            return $next($request);
        }

        if (method_exists($user, 'is_admin_role') && $user->is_admin_role()) {
            return $next($request);
        }

        if ((string) ($user->role ?? '') === 'admin' || (string) ($user->role ?? '') === 'super_admin') {
            return $next($request);
        }

        if (! $user->is_admin) {
            abort(403);
        }

        return $next($request);
    }
}
