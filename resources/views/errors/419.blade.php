@extends('layouts.site')

@section('title', '419 | Windsor AI Club')
@section('body_class', 'events-page error-page')

@section('content')
    <div class="events-hero">
        @include('partials.site.header', ['header_class' => 'events-nav'])
        <div class="events-hero-content" data-reveal>
            <a class="back-link" href="{{ route('home') }}" data-reveal>← Back</a>
            <h1 data-reveal>Session expired</h1>
            <p class="events-season" data-reveal>419</p>
            <p class="sub" data-reveal>Please refresh the page and try again.</p>
        </div>
    </div>

    <div class="events-shell">
        <div class="panel-card" data-reveal>
            <div class="panel-actions">
                <a class="btn primary breath" href="{{ url()->previous() }}">Go back</a>
                <a class="btn secondary" href="{{ route('login') }}">Log in</a>
            </div>
        </div>
    </div>

    @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection

