@extends('layouts.site')

@section('title', 'Profile | Windsor AI Club')
@section('body_class', 'events-page dashboard-page')

@section('content')
    <div class="events-hero">
        @include('partials.site.header', ['header_class' => 'events-nav'])
        <div class="events-hero-content" data-reveal>
            <a class="back-link" href="{{ route('dashboard') }}" data-reveal>← Back</a>
            <h1 data-reveal>Profile</h1>
            <p class="events-season" data-reveal>Account settings</p>
            <p class="sub" data-reveal>Update your account information and password.</p>
        </div>
    </div>

    <div class="events-shell">
        <div class="portal-grid" data-reveal>
            <div class="portal-tile portal-tile-form" style="grid-column: span 12;">
                <div class="portal-kicker">Profile</div>
                <div class="portal-title">Info</div>
                <div class="portal-desc">Name and email address.</div>

                @if (session('status') === 'profile-updated')
                    <div class="auth-status">Saved.</div>
                @endif

                <form class="auth-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <label class="auth-label" for="avatar">Avatar (optional)</label>
                    <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                        @php
                            $avatar_url = $user->avatar_path ? \Illuminate\Support\Facades\Storage::url($user->avatar_path) : null;
                            $initials = collect(explode(' ', trim($user->name ?: 'U')))
                                ->filter()
                                ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
                                ->take(2)
                                ->implode('');
                        @endphp
                        <div class="leader-photo placeholder" style="width:56px; height:56px; font-size:16px; border-radius:14px; overflow:hidden;">
                            @if ($avatar_url)
                                <img src="{{ $avatar_url }}" alt="Avatar" style="width:100%; height:100%; object-fit:cover;" />
                            @else
                                {{ $initials }}
                            @endif
                        </div>
                        <input id="avatar" class="auth-input" name="avatar" type="file" accept="image/*" />
                    </div>
                    @error('avatar') <div class="auth-error">{{ $message }}</div> @enderror

                    <div class="field-grid cols-2">
                        <div>
                            <label class="auth-label" for="name">{{ __('Name') }}</label>
                            <input id="name" class="auth-input" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                            @error('name') <div class="auth-error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="auth-label" for="email">{{ __('Email') }}</label>
                            <input id="email" class="auth-input" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                            @error('email') <div class="auth-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <label class="auth-label" for="tagline">Tagline (optional)</label>
                    <input id="tagline" class="auth-input" name="tagline" type="text" value="{{ old('tagline', $user->tagline) }}" maxlength="140" />
                    @error('tagline') <div class="auth-error">{{ $message }}</div> @enderror

                    <label class="auth-label" for="bio">Bio (optional)</label>
                    <textarea id="bio" class="auth-input" name="bio" rows="5" style="resize:vertical;">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio') <div class="auth-error">{{ $message }}</div> @enderror

                    <div class="field-grid cols-2">
                        <div>
                            <label class="auth-label" for="linkedin_url">LinkedIn URL (optional)</label>
                            <input id="linkedin_url" class="auth-input" name="linkedin_url" type="url" value="{{ old('linkedin_url', $user->linkedin_url) }}" placeholder="https://linkedin.com/in/..." />
                            @error('linkedin_url') <div class="auth-error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="auth-label" for="github_url">GitHub URL (optional)</label>
                            <input id="github_url" class="auth-input" name="github_url" type="url" value="{{ old('github_url', $user->github_url) }}" placeholder="https://github.com/..." />
                            @error('github_url') <div class="auth-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="auth-actions">
                        <button class="btn primary breath" type="submit">{{ __('Save') }}</button>
                        <a class="btn secondary" href="{{ route('dashboard') }}">Back</a>
                    </div>
                </form>
            </div>

            <div class="portal-tile portal-tile-form" style="grid-column: span 12;">
                <div class="portal-kicker">Security</div>
                <div class="portal-title">Password</div>
                <div class="portal-desc">Use a long, random password.</div>

                @if (session('status') === 'password-updated')
                    <div class="auth-status">Password updated.</div>
                @endif

                <form class="auth-form" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <label class="auth-label" for="current_password">{{ __('Current Password') }}</label>
                    <input id="current_password" class="auth-input" name="current_password" type="password" autocomplete="current-password" />
                    @if ($errors->updatePassword->has('current_password'))
                        <div class="auth-error">{{ $errors->updatePassword->first('current_password') }}</div>
                    @endif

                    <div class="field-grid cols-2">
                        <div>
                            <label class="auth-label" for="password">{{ __('New Password') }}</label>
                            <input id="password" class="auth-input" name="password" type="password" autocomplete="new-password" />
                            @if ($errors->updatePassword->has('password'))
                                <div class="auth-error">{{ $errors->updatePassword->first('password') }}</div>
                            @endif
                        </div>
                        <div>
                            <label class="auth-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                            <input id="password_confirmation" class="auth-input" name="password_confirmation" type="password" autocomplete="new-password" />
                            @if ($errors->updatePassword->has('password_confirmation'))
                                <div class="auth-error">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="auth-actions">
                        <button class="btn primary breath" type="submit">{{ __('Save') }}</button>
                    </div>
                </form>

                <details style="margin-top: 14px;">
                    <summary class="auth-label" style="cursor:pointer;">Danger zone (delete account)</summary>
                    <div style="margin-top: 10px;">
                        @if (! $can_delete_account)
                            <p class="portal-desc" style="margin:0;">
                                This account is protected. Transfer ownership in <a href="{{ route('admin.users.index') }}">Admin · Users</a> before deleting it.
                            </p>
                        @else
                            <p class="portal-desc" style="margin:0 0 12px;">
                                This permanently deletes your account. This action cannot be undone.
                            </p>

                            <form class="auth-form" method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Delete your account permanently?');">
                                @csrf
                                @method('DELETE')

                                <label class="auth-label" for="delete_password">{{ __('Password') }}</label>
                                <input id="delete_password" class="auth-input" name="password" type="password" autocomplete="current-password" />
                                @if ($errors->userDeletion->has('password'))
                                    <div class="auth-error">{{ $errors->userDeletion->first('password') }}</div>
                                @endif

                                <div class="auth-actions">
                                    <button class="btn danger" type="submit">{{ __('Delete account') }}</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </details>
            </div>
        </div>
    </div>

    @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection
