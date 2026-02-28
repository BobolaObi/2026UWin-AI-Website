@extends('layouts.site')

@section('title', 'Join | Windsor AI Club')
@section('body_class', 'events-page join-page')

@section('content')
  <div class="events-hero">
    @include('partials.site.header', ['header_class' => 'events-nav'])
    <div class="events-hero-content" data-reveal>
      <a class="back-link" href="{{ route('home') }}" data-reveal>← Back</a>
      <h1 data-reveal>Join</h1>
      <p class="events-season" data-reveal>Get involved this week</p>
      <p class="sub" data-reveal>We’re a student-led AI community at the University of Windsor. If you’re curious, you belong here.</p>
    </div>
  </div>

  <div class="events-shell">
    <section class="join-grid">
      <div class="join-card" data-reveal>
        <div class="join-badge">01</div>
        <h2>Join Discord</h2>
        <p>Announcements, meetups, project teams, and office hours.</p>
        <a class="join-link" href="https://discord.gg/mGmrU7Gr6N" target="_blank" rel="noreferrer">Open Discord →</a>
      </div>
      <div class="join-card" data-reveal>
        <div class="join-badge">02</div>
        <h2>Get updates</h2>
        <p>Follow the club for announcements and event drops.</p>
        <div class="join-links">
          <a class="join-link" href="https://www.instagram.com/uwindsor.ai.club/" target="_blank" rel="noreferrer">Instagram →</a>
          <a class="join-link" href="https://www.linkedin.com/company/uwindsor-ai-club" target="_blank" rel="noreferrer">LinkedIn →</a>
        </div>
      </div>
      <div class="join-card" data-reveal>
        <div class="join-badge">03</div>
        <h2>Show up</h2>
        <p>New to AI? Come to a lab. Experienced? Help someone ship.</p>
        <a class="join-link" href="{{ route('events') }}">See events →</a>
      </div>
    </section>
  </div>

  @include('partials.site.footer')
@endsection
