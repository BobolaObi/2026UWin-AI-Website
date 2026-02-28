<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class AdminEventsController extends Controller
{
    public function index(): View
    {
        $events = Event::query()
            ->orderByDesc('starts_at')
            ->orderByDesc('id')
            ->get();

        return view('admin.events.index', [
            'events' => $events,
        ]);
    }

    public function create(): View
    {
        return view('admin.events.form', [
            'event' => new Event([
                'is_published' => true,
                'sort_order' => 0,
            ]),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated_data($request);
        $event = Event::create($data);

        $this->audit($request, 'events.create', [
            'event_id' => $event->id,
        ]);

        return redirect()->route('admin.events.index')->with('status', 'Event created.');
    }

    public function edit(Event $event): View
    {
        return view('admin.events.form', [
            'event' => $event,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $data = $this->validated_data($request);
        $event->fill($data);
        $event->save();

        $this->audit($request, 'events.update', [
            'event_id' => $event->id,
        ]);

        return redirect()->route('admin.events.index')->with('status', 'Event updated.');
    }

    public function destroy(Request $request, Event $event): RedirectResponse
    {
        $event_id = $event->id;
        $event->delete();

        $this->audit($request, 'events.delete', [
            'event_id' => $event_id,
        ]);

        return redirect()->route('admin.events.index')->with('status', 'Event deleted.');
    }

    private function validated_data(Request $request): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'starts_at' => ['required', 'date_format:Y-m-d\\TH:i'],
            'ends_at' => ['required', 'date_format:Y-m-d\\TH:i', 'after:starts_at'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:4000'],
            'is_published' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:1000000'],
        ]);

        $timezone = config('app.timezone');
        $starts_at = Carbon::createFromFormat('Y-m-d\\TH:i', (string) $validated['starts_at'], $timezone)->seconds(0);
        $ends_at = Carbon::createFromFormat('Y-m-d\\TH:i', (string) $validated['ends_at'], $timezone)->seconds(0);

        return [
            'title' => (string) $validated['title'],
            'starts_at' => $starts_at,
            'ends_at' => $ends_at,
            'location' => isset($validated['location']) ? (string) $validated['location'] : null,
            'description' => isset($validated['description']) ? (string) $validated['description'] : null,
            'is_published' => (bool) ($validated['is_published'] ?? false),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
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
