@extends('layouts.site')

@section('title', 'Forgot password | Windsor AI Club')
@section('body_class', 'events-page auth-page')

@section('content')
    <div class="events-hero">
        @include('partials.site.header', ['header_class' => 'events-nav'])
        <div class="events-hero-content" data-reveal>
            <a class="back-link" href="{{ route('login') }}" data-reveal>← Back</a>
            <h1 data-reveal>Reset password</h1>
            <p class="events-season" data-reveal>We’ll email you a link</p>
            <p class="sub" data-reveal>Enter your email address and we’ll send a password reset link.</p>
        </div>
    </div>

    <div class="events-shell">
        <div class="auth-card" data-reveal>
            @if (session('status'))
                <div class="auth-status">{{ session('status') }}</div>
            @endif

            <form class="auth-form" method="POST" action="{{ route('password.email') }}">
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

                <div class="auth-actions">
                    <button class="btn primary breath" type="submit">{{ __('Email reset link') }}</button>
                    <a class="btn secondary" href="{{ route('login') }}">{{ __('Back to login') }}</a>
                </div>
            </form>
        </div>
    </div>

    @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection
