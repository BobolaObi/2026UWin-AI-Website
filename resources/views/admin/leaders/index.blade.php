@extends('layouts.site')

@section('title', 'Admin Leaders | Windsor AI Club')
@section('body_class', 'events-page admin-page')

@section('content')
    <div class="events-hero">
        @include('partials.site.header', ['header_class' => 'events-nav'])
        <div class="events-hero-content" data-reveal>
            <a class="back-link" href="{{ route('dashboard') }}" data-reveal>← Back</a>
            <h1 data-reveal>Admin · Leaders</h1>
            <p class="events-season" data-reveal>Curate the public leaders page</p>
        </div>
    </div>

    <div class="events-shell">
        <div class="panel-card panel-card-wide" data-reveal>
            @if (session('status'))
                <div class="auth-status">{{ session('status') }}</div>
            @endif

            <div class="panel-actions panel-actions-spaced">
                <a class="btn primary breath" href="{{ route('admin.leaders.create') }}">Add leader</a>
                <a class="btn secondary" href="{{ route('leaders') }}" target="_blank" rel="noreferrer">Preview</a>
            </div>

            <div class="leaders-grid" style="margin-top: 14px;">
                @forelse ($leaders as $leader)
                    @php
                        $initials = collect(explode(' ', trim($leader->name ?: 'L')))
                            ->filter()
                            ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
                            ->take(2)
                            ->implode('');
                        $photo = $leader->photo_path ? (str_starts_with($leader->photo_path, 'http') ? $leader->photo_path : asset($leader->photo_path)) : null;
                    @endphp
                    <div class="leader-card breath" data-reveal>
                        @if ($photo)
                            <img class="leader-photo" src="{{ $photo }}" alt="{{ $leader->name }}" loading="lazy" />
                        @else
                            <div class="leader-photo placeholder">{{ $initials }}</div>
                        @endif

                        <h3 style="display:flex; align-items:flex-start; justify-content:space-between; gap:10px;">
                            <span>{{ $leader->name }}</span>
                            <span class="badge badge-draft" style="margin-top:2px;">#{{ $leader->sort_order }}</span>
                        </h3>

                        @if ($leader->title)
                            <span class="leader-role">{{ $leader->title }}</span>
                        @endif
                        @if ($leader->bio)
                            <p class="leader-focus">{{ $leader->bio }}</p>
                        @endif

                        <div class="panel-actions" style="margin-top: 10px;">
                            <a class="btn secondary" href="{{ route('admin.leaders.edit', $leader) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.leaders.destroy', $leader) }}" onsubmit="return confirm('Remove this leader?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn secondary" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="panel-card" data-reveal>
                        <div class="panel-kicker">No leaders yet</div>
                        <p class="sub" style="margin:0;">Add a leader to populate the public leaders page.</p>
                        <div class="panel-actions" style="margin-top:12px;">
                            <a class="btn primary breath" href="{{ route('admin.leaders.create') }}">Add leader</a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection

