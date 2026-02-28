<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Leader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminLeadersController extends Controller
{
    public function index(): View
    {
        $leaders = Leader::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.leaders.index', [
            'leaders' => $leaders,
        ]);
    }

    public function create(): View
    {
        return view('admin.leaders.form', [
            'leader' => new Leader(['sort_order' => 0]),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $leader = Leader::create($this->validated_data($request));

        $this->audit($request, 'leaders.create', [
            'leader_id' => $leader->id,
        ]);

        return redirect()->route('admin.leaders.index')->with('status', 'Leader added.');
    }

    public function edit(Leader $leader): View
    {
        return view('admin.leaders.form', [
            'leader' => $leader,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, Leader $leader): RedirectResponse
    {
        $leader->fill($this->validated_data($request));
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

    private function validated_data(Request $request): array
    {
        $validated = $request->validate([
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'name' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:4000'],
            'photo_path' => ['nullable', 'string', 'max:255'],
            'linkedin_url' => ['nullable', 'string', 'max:255', 'url'],
            'github_url' => ['nullable', 'string', 'max:255', 'url'],
        ]);

        return [
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
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

