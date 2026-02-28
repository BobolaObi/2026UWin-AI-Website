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
        @php
            /** @var \App\Models\User $user */
            $user = auth()->user();
            $role = $user->role ?: \App\Models\User::ROLE_MEMBER;
            $can_edit_events = $user->is_editor_role();
            $can_manage_users = $user->is_admin_role();
        @endphp

        <div class="portal-meta" data-reveal>
            Signed in as <strong>{{ $user->email }}</strong>
            <span class="portal-pill">{{ $role }}</span>
        </div>

        <div class="portal-grid" data-reveal>
            <a class="portal-tile" href="{{ route('profile.edit') }}">
                <div class="portal-kicker">Account</div>
                <div class="portal-title">Profile</div>
                <div class="portal-desc">Update your name, email, and password.</div>
            </a>

            <a class="portal-tile" href="{{ route('events') }}">
                <div class="portal-kicker">Club</div>
                <div class="portal-title">Events</div>
                <div class="portal-desc">See upcoming events and add them to your calendar.</div>
            </a>

            @if ($can_edit_events)
                <a class="portal-tile portal-tile-accent" href="{{ route('admin.events.index') }}">
                    <div class="portal-kicker">Editor</div>
                    <div class="portal-title">Edit events</div>
                    <div class="portal-desc">Create, update, publish/unpublish, and delete events.</div>
                </a>
            @endif

            @if ($can_manage_users)
                <a class="portal-tile portal-tile-accent" href="{{ route('admin.users.index') }}">
                    <div class="portal-kicker">Admin</div>
                    <div class="portal-title">Manage users</div>
                    <div class="portal-desc">Assign roles and manage access.</div>
                </a>

                <a class="portal-tile portal-tile-accent" href="{{ route('admin.leaders.index') }}">
                    <div class="portal-kicker">Admin</div>
                    <div class="portal-title">Leaders page</div>
                    <div class="portal-desc">Curate who appears on the public leaders page.</div>
                </a>
            @endif

            <form class="portal-tile portal-tile-form" method="POST" action="{{ route('logout') }}">
                @csrf
                <div class="portal-kicker">Session</div>
                <div class="portal-title">Log out</div>
                <div class="portal-desc">Sign out of your account on this device.</div>
                <button class="btn secondary" type="submit">Log out</button>
            </form>
        </div>
    </div>

    @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection
