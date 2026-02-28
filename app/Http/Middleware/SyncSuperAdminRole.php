<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\SuperAdminService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SyncSuperAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return $next($request);
        }

        /** @var User $user */
        $user = $request->user();

        /** @var SuperAdminService $super_admin_service */
        $super_admin_service = app(SuperAdminService::class);
        $super_admin_service->sync_roles_for_request($user);

        return $next($request);
    }
}

