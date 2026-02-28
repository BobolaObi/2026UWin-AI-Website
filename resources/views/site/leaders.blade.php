@extends('layouts.site')

@section('title', 'Leaders | Windsor AI Club')
@section('body_class', 'events-page leaders-page')

@section('content')
  <div class="shell">
    @include('partials.site.header')

    <section class="leaders-hero">
      <h1 data-reveal>Group Leaders</h1>
      <p data-reveal>Meet the students and mentors guiding our labs, research pods, and community events.</p>
    </section>

    <section class="leaders-shell">
      <div class="leaders-grid">
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
            <h3>{{ $leader->name }}</h3>
            @if ($leader->title)
              <span class="leader-role">{{ $leader->title }}</span>
            @endif
            @if ($leader->bio)
              <p class="leader-focus">{{ $leader->bio }}</p>
            @endif
            @if ($leader->linkedin_url || $leader->github_url)
              <div class="leader-links">
                @if ($leader->linkedin_url)
                  <a href="{{ $leader->linkedin_url }}" target="_blank" rel="noreferrer">LinkedIn</a>
                @endif
                @if ($leader->github_url)
                  <a href="{{ $leader->github_url }}" target="_blank" rel="noreferrer">GitHub</a>
                @endif
              </div>
            @endif
          </div>
        @empty
          <div class="panel-card" data-reveal>
            <div class="panel-kicker">No leaders yet</div>
            <p class="sub" style="margin:0;">Check back soon.</p>
          </div>
        @endforelse
      </div>
    </section>
  </div>

  @include('partials.site.footer')
@endsection
