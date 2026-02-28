@extends('layouts.site')

@section('title', 'Dashboard | Windsor AI Club')
@section('body_class', 'events-page dashboard-page')

@section('content')
    <div class="events-hero">
        @include('partials.site.header', ['header_class' => 'events-nav'])
        <div class="events-hero-content" data-reveal>
            <a class="back-link" href="{{ route('home') }}" data-reveal>← Back</a>
            <h1 data-reveal>Dashboard</h1>
            <p class="events-season" data-reveal>Member portal</p>
            <p class="sub" data-reveal>Quick links for your account.</p>
        </div>
    </div>

    <div class="events-shell">
        <div class="dashboard-grid" data-reveal>
            <div class="panel-card">
                <div class="panel-kicker">Account</div>
                <ul class="panel-list">
                    <li><strong>Email:</strong> {{ auth()->user()->email }}</li>
                    <li><strong>Status:</strong> Logged in</li>
                    @if (auth()->user()->is_admin)
                        <li><strong>Role:</strong> Admin</li>
                    @endif
                </ul>

                <div class="panel-actions">
                    <a class="btn primary breath" href="{{ route('profile.edit') }}">Profile</a>
                    @if (auth()->user()->is_admin)
                        <a class="btn secondary" href="{{ route('admin.index') }}">Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn secondary" type="submit">Log out</button>
                    </form>
                </div>
            </div>

            <div class="panel-card">
                <div class="panel-kicker">Explore</div>
                <ul class="panel-list">
                    <li><a href="{{ route('events') }}">See upcoming events</a></li>
                    <li><a href="{{ route('leaders') }}">Meet the leaders</a></li>
                    <li><a href="{{ route('join') }}">Share the join link</a></li>
                </ul>
            </div>
        </div>
    </div>

    @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection
