@extends('layouts.site')

@section('title', '503 | Windsor AI Club')
@section('body_class', 'events-page error-page')

@section('content')
    <div class="events-hero">
        @include('partials.site.header', ['header_class' => 'events-nav'])
        <div class="events-hero-content" data-reveal>
            <a class="back-link" href="{{ route('home') }}" data-reveal>← Back</a>
            <h1 data-reveal>Down for maintenance</h1>
            <p class="events-season" data-reveal>503</p>
            <p class="sub" data-reveal>We’ll be back soon.</p>
        </div>
    </div>

    <div class="events-shell">
        <div class="panel-card" data-reveal>
            <div class="panel-actions">
                <a class="btn primary breath" href="{{ route('home') }}">Home</a>
            </div>
        </div>
    </div>

    @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection

