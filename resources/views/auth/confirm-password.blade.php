@extends('layouts.site')

@section('title', 'Confirm password | Windsor AI Club')
@section('body_class', 'events-page auth-page')

@section('content')
    <div class="events-hero">
        @include('partials.site.header', ['header_class' => 'events-nav'])
        <div class="events-hero-content" data-reveal>
            <a class="back-link" href="{{ route('dashboard') }}" data-reveal>← Back</a>
            <h1 data-reveal>Confirm password</h1>
            <p class="events-season" data-reveal>Security check</p>
            <p class="sub" data-reveal>{{ __('Please confirm your password before continuing.') }}</p>
        </div>
    </div>

    <div class="events-shell">
        <div class="auth-card" data-reveal>
            <form class="auth-form" method="POST" action="{{ route('password.confirm') }}">
                @csrf

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

                <div class="auth-actions">
                    <button class="btn primary breath" type="submit">{{ __('Confirm') }}</button>
                    <a class="btn secondary" href="{{ route('dashboard') }}">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>

    @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection
