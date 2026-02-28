<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class SiteEventsController extends Controller
{
    public function index(): View
    {
        $events = Event::query()
            ->where('is_published', true)
            ->orderBy('starts_at')
            ->orderBy('sort_order')
            ->get();

        return view('site.events', [
            'events' => $events,
        ]);
    }
}
