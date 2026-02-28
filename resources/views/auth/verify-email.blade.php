@extends('layouts.site')

@section('title', 'Verify email | Windsor AI Club')
@section('body_class', 'events-page auth-page')

@section('content')
    <div class="events-hero">
        @include('partials.site.header', ['header_class' => 'events-nav'])
        <div class="events-hero-content" data-reveal>
            <a class="back-link" href="{{ route('dashboard') }}" data-reveal>← Back</a>
            <h1 data-reveal>Verify your email</h1>
            <p class="events-season" data-reveal>Almost there</p>
            <p class="sub" data-reveal>
                {{ __("Before getting started, please verify your email address by clicking the link we emailed you. If you didn't receive it, we can send another.") }}
            </p>
        </div>
    </div>

    <div class="events-shell">
        <div class="auth-card" data-reveal>
            @if (session('status') === 'verification-link-sent')
                <div class="auth-status">{{ __('A new verification link has been sent to your email address.') }}</div>
            @endif

            <div class="auth-actions">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button class="btn primary breath" type="submit">{{ __('Resend email') }}</button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn secondary" type="submit">{{ __('Log out') }}</button>
                </form>
            </div>
        </div>
    </div>

    @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection
