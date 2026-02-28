@extends('layouts.site')

@section('title', ($mode === 'edit' ? 'Edit event' : 'New event').' | Windsor AI Club')
@section('body_class', 'events-page admin-page')

@section('content')
    <div class="events-hero">
        @include('partials.site.header', ['header_class' => 'events-nav'])
        <div class="events-hero-content" data-reveal>
            <a class="back-link" href="{{ route('admin.events.index') }}" data-reveal>← Back</a>
            <h1 data-reveal>{{ $mode === 'edit' ? 'Edit event' : 'New event' }}</h1>
            <p class="events-season" data-reveal>Admin · Events</p>
        </div>
    </div>

    <div class="events-shell">
        <div class="panel-card" data-reveal>
            <form class="auth-form" method="POST" action="{{ $mode === 'edit' ? route('admin.events.update', $event) : route('admin.events.store') }}">
                @csrf
                @if ($mode === 'edit')
                    @method('PUT')
                @endif

                <label class="auth-label" for="title">Title</label>
                <input id="title" class="auth-input" name="title" type="text" value="{{ old('title', $event->title) }}" required />
                @error('title') <div class="auth-error">{{ $message }}</div> @enderror

                <label class="auth-label" for="starts_at">Start</label>
                <input
                    id="starts_at"
                    class="auth-input"
                    name="starts_at"
                    type="datetime-local"
                    value="{{ old('starts_at', $event->starts_at ? $event->starts_at->timezone(config('app.timezone'))->format('Y-m-d\\TH:i') : '') }}"
                    required
                />
                @error('starts_at') <div class="auth-error">{{ $message }}</div> @enderror

                <label class="auth-label" for="ends_at">End</label>
                <input
                    id="ends_at"
                    class="auth-input"
                    name="ends_at"
                    type="datetime-local"
                    value="{{ old('ends_at', $event->ends_at ? $event->ends_at->timezone(config('app.timezone'))->format('Y-m-d\\TH:i') : '') }}"
                    required
                />
                @error('ends_at') <div class="auth-error">{{ $message }}</div> @enderror

                <label class="auth-label" for="location">Location</label>
                <input id="location" class="auth-input" name="location" type="text" value="{{ old('location', $event->location) }}" />
                @error('location') <div class="auth-error">{{ $message }}</div> @enderror

                <label class="auth-label" for="description">Description</label>
                <textarea id="description" class="auth-input auth-textarea" name="description" rows="4">{{ old('description', $event->description) }}</textarea>
                @error('description') <div class="auth-error">{{ $message }}</div> @enderror

                <label class="auth-label" for="sort_order">Sort order (optional)</label>
                <input id="sort_order" class="auth-input" name="sort_order" type="number" min="0" step="1" value="{{ old('sort_order', $event->sort_order ?? 0) }}" />
                @error('sort_order') <div class="auth-error">{{ $message }}</div> @enderror

                <label class="auth-checkbox" for="is_published">
                    <input id="is_published" type="checkbox" name="is_published" value="1" {{ old('is_published', $event->is_published) ? 'checked' : '' }} />
                    <span>Published</span>
                </label>

                <div class="auth-actions">
                    <button class="btn primary breath" type="submit">{{ $mode === 'edit' ? 'Save changes' : 'Create event' }}</button>
                    <a class="btn secondary" href="{{ route('admin.events.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection

