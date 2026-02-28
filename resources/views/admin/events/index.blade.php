@extends('layouts.site')

@section('title', 'Admin Events | Windsor AI Club')
@section('body_class', 'events-page admin-page')

@section('content')
    <div class="events-hero">
        @include('partials.site.header', ['header_class' => 'events-nav'])
        <div class="events-hero-content" data-reveal>
            <a class="back-link" href="{{ route('dashboard') }}" data-reveal>← Back</a>
            <h1 data-reveal>Admin · Events</h1>
            <p class="events-season" data-reveal>Edit the public events list</p>
        </div>
    </div>

    <div class="events-shell">
        <div class="panel-card" data-reveal>
            @if (session('status'))
                <div class="auth-status">{{ session('status') }}</div>
            @endif

            <div class="panel-actions" style="margin-bottom: 12px;">
                <a class="btn primary breath" href="{{ route('admin.events.create') }}">New event</a>
                <a class="btn secondary" href="{{ route('events') }}" target="_blank" rel="noreferrer">View site events</a>
            </div>

            <div class="admin-table">
                <div class="admin-row admin-head">
                    <div>Title</div>
                    <div>When</div>
                    <div>Status</div>
                    <div></div>
                </div>

                @forelse ($events as $event)
                    @php
                        $when = $event->starts_at
                            ? $event->starts_at->timezone(config('app.timezone'))->format('M j, Y g:i A')
                            : '';
                    @endphp
                    <div class="admin-row">
                        <div class="admin-title">{{ $event->title }}</div>
                        <div class="admin-when">{{ $when }}</div>
                        <div>
                            <span class="badge {{ $event->is_published ? 'badge-live' : 'badge-draft' }}">
                                {{ $event->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                        <div class="admin-actions">
                            <a class="btn secondary" href="{{ route('admin.events.edit', $event) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Delete this event?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn secondary" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="admin-empty">
                        No events yet. Create one with “New event”.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection

