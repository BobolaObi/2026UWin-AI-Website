<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use App\Services\SuperAdminService;
use App\Support\Roles;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUsersController extends Controller
{
    public function index(Request $request, SuperAdminService $super_admin_service): View
    {
        /** @var \App\Models\User $actor */
        $actor = $request->user();
        $current_super_admin_id = $super_admin_service->current_user_id();
        $is_actor_super_admin = $actor->is_super_admin() || $current_super_admin_id === $actor->id;

        $users_query = User::query()
            ->orderByDesc('created_at')
            ->limit(250);

        if (! $is_actor_super_admin) {
            $users_query->where('role', '!=', User::ROLE_SUPER_ADMIN);
            if ($current_super_admin_id) {
                $users_query->where('id', '!=', $current_super_admin_id);
            }
        }

        $users = $users_query->get();

        return view('admin.users.index', [
            'users' => $users,
            'current_super_admin_id' => $current_super_admin_id,
            'is_actor_super_admin' => $is_actor_super_admin,
        ]);
    }

    public function update_role(
        Request $request,
        User $user,
        SuperAdminService $super_admin_service
    ): RedirectResponse {
        $validated = $request->validate([
            'role' => ['required', 'string'],
        ]);

        $requested_role = (string) $validated['role'];
        if (! Roles::is_valid($requested_role)) {
            abort(422);
        }

        /** @var \App\Models\User $actor */
        $actor = $request->user();

        $is_actor_super_admin = $actor->is_super_admin() || $super_admin_service->current_user_id() === $actor->id;
        if (! $is_actor_super_admin) {
            abort(403);
        }

        if ($requested_role === User::ROLE_SUPER_ADMIN) {
            $request->validate([
                'password' => ['required', 'current_password'],
            ]);

            $super_admin_service->ensure($user);
            $this->audit($request, 'users.transfer_owner', [
                'target_user_id' => $user->id,
            ]);

            return redirect()->route('admin.users.index')->with('status', 'Primary admin updated.');
        }

        $current_super_admin_id = $super_admin_service->current_user_id();
        if ($current_super_admin_id === $user->id && $requested_role !== User::ROLE_SUPER_ADMIN) {
            abort(422);
        }

        $user->role = $requested_role;
        $user->is_admin = $requested_role === User::ROLE_ADMIN || $requested_role === User::ROLE_SUPER_ADMIN;
        $user->save();

        $this->audit($request, 'users.set_role', [
            'target_user_id' => $user->id,
            'role' => $requested_role,
        ]);

        return redirect()->route('admin.users.index')->with('status', 'Role updated.');
    }

    private function audit(Request $request, string $action, array $details): void
    {
        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => $action,
            'details' => json_encode($details, JSON_THROW_ON_ERROR),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }
}
