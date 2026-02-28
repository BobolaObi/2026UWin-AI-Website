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

            <div class="panel-actions panel-actions-spaced">
                <a class="btn primary breath" href="{{ route('admin.events.create') }}">Add event</a>
                <a class="btn secondary" href="{{ route('events') }}" target="_blank" rel="noreferrer">Preview</a>
            </div>

            <div class="event-admin-list">
                @forelse ($events as $event)
                    @php
                        $timezone = config('app.timezone');
                        $when = ($event->starts_at && $event->ends_at)
                            ? $event->starts_at->timezone($timezone)->format('M j, Y').' · '.$event->starts_at->timezone($timezone)->format('g:i A').'–'.$event->ends_at->timezone($timezone)->format('g:i A')
                            : '';
                        $location_text = $event->location ?: '';
                        $description_text = $event->description ?: '';
                    @endphp
                    <div class="event-row event-row-admin" data-reveal>
                        <div class="event-admin-main">
                            <div class="event-admin-top">
                                <h3 class="event-admin-title">
                                    {{ $event->title }}
                                    @if ($location_text !== '')
                                        <span>{{ $location_text }}</span>
                                    @endif
                                </h3>
                                <span class="badge {{ $event->is_published ? 'badge-live' : 'badge-draft' }}">
                                    {{ $event->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                            @if ($description_text !== '')
                                <p class="event-admin-desc">{{ $description_text }}</p>
                            @endif
                        </div>

                        <div class="event-admin-side">
                            <div class="event-date breath">{{ $when }}</div>
                            <div class="event-admin-actions">
                                <a class="btn secondary" href="{{ route('admin.events.edit', $event) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.events.toggle', $event) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn secondary" type="submit">
                                        {{ $event->is_published ? 'Unpublish' : 'Publish' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Delete this event?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn secondary" type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="panel-card" data-reveal>
                        <div class="panel-kicker">No events yet</div>
                        <p class="sub" style="margin:0;">Create your first event to populate the public events page.</p>
                        <div class="panel-actions" style="margin-top:12px;">
                            <a class="btn primary breath" href="{{ route('admin.events.create') }}">Add event</a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection
