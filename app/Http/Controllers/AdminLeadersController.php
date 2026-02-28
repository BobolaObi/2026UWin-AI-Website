<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Leader;
use App\Services\SuperAdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminLeadersController extends Controller
{
    public function index(Request $request, SuperAdminService $super_admin_service): View
    {
        /** @var \App\Models\User $actor */
        $actor = $request->user();
        $current_owner_id = $super_admin_service->current_user_id();
        $is_actor_owner = $actor->is_super_admin() || ($current_owner_id && $actor->id === $current_owner_id);

        $leaders = Leader::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.leaders.index', [
            'leaders' => $leaders,
            'is_actor_owner' => $is_actor_owner,
        ]);
    }

    public function create(Request $request, SuperAdminService $super_admin_service): View
    {
        /** @var \App\Models\User $actor */
        $actor = $request->user();
        $current_owner_id = $super_admin_service->current_user_id();
        $is_actor_owner = $actor->is_super_admin() || ($current_owner_id && $actor->id === $current_owner_id);

        return view('admin.leaders.form', [
            'leader' => new Leader(['sort_order' => 0]),
            'mode' => 'create',
            'is_actor_owner' => $is_actor_owner,
        ]);
    }

    public function store(Request $request, SuperAdminService $super_admin_service): RedirectResponse
    {
        $leader = Leader::create($this->validated_data($request, $super_admin_service));

        $this->audit($request, 'leaders.create', [
            'leader_id' => $leader->id,
        ]);

        return redirect()->route('admin.leaders.index')->with('status', 'Leader added.');
    }

    public function edit(Request $request, Leader $leader, SuperAdminService $super_admin_service): View
    {
        /** @var \App\Models\User $actor */
        $actor = $request->user();
        $current_owner_id = $super_admin_service->current_user_id();
        $is_actor_owner = $actor->is_super_admin() || ($current_owner_id && $actor->id === $current_owner_id);

        return view('admin.leaders.form', [
            'leader' => $leader,
            'mode' => 'edit',
            'is_actor_owner' => $is_actor_owner,
        ]);
    }

    public function update(Request $request, Leader $leader, SuperAdminService $super_admin_service): RedirectResponse
    {
        $leader->fill($this->validated_data($request, $super_admin_service, $leader));
        $leader->save();

        $this->audit($request, 'leaders.update', [
            'leader_id' => $leader->id,
        ]);

        return redirect()->route('admin.leaders.index')->with('status', 'Leader updated.');
    }

    public function destroy(Request $request, Leader $leader): RedirectResponse
    {
        $leader_id = $leader->id;
        $leader->delete();

        $this->audit($request, 'leaders.delete', [
            'leader_id' => $leader_id,
        ]);

        return redirect()->route('admin.leaders.index')->with('status', 'Leader removed.');
    }

    private function validated_data(
        Request $request,
        SuperAdminService $super_admin_service,
        ?Leader $existing_leader = null
    ): array {
        /** @var \App\Models\User $actor */
        $actor = $request->user();
        $current_owner_id = $super_admin_service->current_user_id();
        $is_actor_owner = $actor->is_super_admin() || ($current_owner_id && $actor->id === $current_owner_id);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:4000'],
            'photo_path' => ['nullable', 'string', 'max:255'],
            'linkedin_url' => ['nullable', 'string', 'max:255', 'url'],
            'github_url' => ['nullable', 'string', 'max:255', 'url'],
        ];

        if ($is_actor_owner) {
            $rules['sort_order'] = ['nullable', 'integer', 'min:0', 'max:1000000'];
        }

        $validated = $request->validate($rules);

        $sort_order = $is_actor_owner
            ? (int) ($validated['sort_order'] ?? 0)
            : (int) ($existing_leader?->sort_order ?? 0);

        return [
            'sort_order' => $sort_order,
            'name' => (string) $validated['name'],
            'title' => isset($validated['title']) ? (string) $validated['title'] : null,
            'bio' => isset($validated['bio']) ? (string) $validated['bio'] : null,
            'photo_path' => isset($validated['photo_path']) ? (string) $validated['photo_path'] : null,
            'linkedin_url' => isset($validated['linkedin_url']) ? (string) $validated['linkedin_url'] : null,
            'github_url' => isset($validated['github_url']) ? (string) $validated['github_url'] : null,
        ];
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
