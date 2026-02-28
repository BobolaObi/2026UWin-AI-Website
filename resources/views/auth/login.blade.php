@extends('layouts.site')

@section('title', 'Log in | Windsor AI Club')
@section('body_class', 'events-page auth-page')

@section('content')
    <div class="events-hero">
        @include('partials.site.header', ['header_class' => 'events-nav'])
        <div class="events-hero-content" data-reveal>
            <a class="back-link" href="{{ route('home') }}" data-reveal>← Back</a>
            <h1 data-reveal>Log in</h1>
            <p class="events-season" data-reveal>Member access</p>
            <p class="sub" data-reveal>Sign in to access your dashboard (and admin tools if enabled).</p>
        </div>
    </div>

    <div class="events-shell">
        <div class="auth-card" data-reveal>
            @if (session('status'))
                <div class="auth-status">{{ session('status') }}</div>
            @endif

            <form class="auth-form" method="POST" action="{{ route('login') }}">
                @csrf

                <label class="auth-label" for="email">{{ __('Email') }}</label>
                <input
                    id="email"
                    class="auth-input"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                />
                @error('email')
                    <div class="auth-error">{{ $message }}</div>
                @enderror

                <label class="auth-label" for="password">{{ __('Password') }}</label>
                <input
                    id="password"
                    class="auth-input"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                />
                @error('password')
                    <div class="auth-error">{{ $message }}</div>
                @enderror

                <label class="auth-checkbox" for="remember_me">
                    <input id="remember_me" type="checkbox" name="remember" />
                    <span>{{ __('Remember me') }}</span>
                </label>

                <div class="auth-actions">
                    <button class="btn primary breath" type="submit">{{ __('Log in') }}</button>

                    @if (Route::has('password.request'))
                        <a class="btn secondary" href="{{ route('password.request') }}">{{ __('Forgot password') }}</a>
                    @endif
                </div>

                <div class="auth-meta">
                    <span>{{ __('New here?') }}</span>
                    <a href="{{ route('register') }}">{{ __('Create an account') }}</a>
                </div>
            </form>
        </div>
    </div>

    @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection
