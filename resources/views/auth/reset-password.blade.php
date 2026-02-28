@extends('layouts.site')

@section('title', 'Reset password | Windsor AI Club')
@section('body_class', 'events-page auth-page')

@section('content')
    <div class="events-hero">
        @include('partials.site.header', ['header_class' => 'events-nav'])
        <div class="events-hero-content" data-reveal>
            <a class="back-link" href="{{ route('login') }}" data-reveal>← Back</a>
            <h1 data-reveal>Choose a new password</h1>
            <p class="events-season" data-reveal>Secure reset</p>
            <p class="sub" data-reveal>Set a new password for your account.</p>
        </div>
    </div>

    <div class="events-shell">
        <div class="auth-card" data-reveal>
            <form class="auth-form" method="POST" action="{{ route('password.store') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <label class="auth-label" for="email">{{ __('Email') }}</label>
                <input
                    id="email"
                    class="auth-input"
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
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
                    autocomplete="new-password"
                />
                @error('password')
                    <div class="auth-error">{{ $message }}</div>
                @enderror

                <label class="auth-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                <input
                    id="password_confirmation"
                    class="auth-input"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                />
                @error('password_confirmation')
                    <div class="auth-error">{{ $message }}</div>
                @enderror

                <div class="auth-actions">
                    <button class="btn primary breath" type="submit">{{ __('Reset password') }}</button>
                    <a class="btn secondary" href="{{ route('login') }}">{{ __('Back to login') }}</a>
                </div>
            </form>
        </div>
    </div>

    @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection
