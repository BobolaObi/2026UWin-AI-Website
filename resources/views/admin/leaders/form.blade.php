@extends('layouts.site')

@section('title', ($mode === 'edit' ? 'Edit Leader' : 'Add Leader').' | Windsor AI Club')
@section('body_class', 'events-page admin-page')

@section('content')
    <div class="events-hero">
        @include('partials.site.header', ['header_class' => 'events-nav'])
        <div class="events-hero-content" data-reveal>
            <a class="back-link" href="{{ route('admin.leaders.index') }}" data-reveal>← Back</a>
            <h1 data-reveal>{{ $mode === 'edit' ? 'Edit leader' : 'Add leader' }}</h1>
            <p class="events-season" data-reveal>Shown on the public leaders page</p>
        </div>
    </div>

    <div class="events-shell">
        <div class="portal-grid" data-reveal>
            <div class="portal-tile portal-tile-form" style="grid-column: span 12;">
                <div class="portal-kicker">Leader</div>
                <div class="portal-title">{{ $mode === 'edit' ? 'Details' : 'New entry' }}</div>
                <div class="portal-desc">Keep it short and professional.</div>

                <form class="auth-form" method="POST"
                      action="{{ $mode === 'edit' ? route('admin.leaders.update', $leader) : route('admin.leaders.store') }}">
                    @csrf
                    @if ($mode === 'edit')
                        @method('PUT')
                    @endif

                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:12px;">
                        @if ($is_actor_owner ?? false)
                            <div>
                                <label class="auth-label" for="sort_order">Order</label>
                                <input id="sort_order" class="auth-input" name="sort_order" type="number" min="0" max="1000000"
                                       value="{{ old('sort_order', $leader->sort_order) }}" />
                                @error('sort_order') <div class="auth-error">{{ $message }}</div> @enderror
                            </div>
                        @endif
                        <div>
                            <label class="auth-label" for="name">Name</label>
                            <input id="name" class="auth-input" name="name" type="text" required
                                   value="{{ old('name', $leader->name) }}" />
                            @error('name') <div class="auth-error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="auth-label" for="title">Title (optional)</label>
                            <input id="title" class="auth-input" name="title" type="text"
                                   value="{{ old('title', $leader->title) }}" />
                            @error('title') <div class="auth-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <label class="auth-label" for="bio">Bio (optional)</label>
                    <textarea id="bio" class="auth-input" name="bio" rows="5" style="resize:vertical;">{{ old('bio', $leader->bio) }}</textarea>
                    @error('bio') <div class="auth-error">{{ $message }}</div> @enderror

                    <label class="auth-label" for="photo_path">Photo path or URL (optional)</label>
                    <input id="photo_path" class="auth-input" name="photo_path" type="text"
                           value="{{ old('photo_path', $leader->photo_path) }}"
                           placeholder="images/leaders/name.jpg or https://..." />
                    @error('photo_path') <div class="auth-error">{{ $message }}</div> @enderror

                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:12px;">
                        <div>
                            <label class="auth-label" for="linkedin_url">LinkedIn URL (optional)</label>
                            <input id="linkedin_url" class="auth-input" name="linkedin_url" type="url"
                                   value="{{ old('linkedin_url', $leader->linkedin_url) }}" />
                            @error('linkedin_url') <div class="auth-error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="auth-label" for="github_url">GitHub URL (optional)</label>
                            <input id="github_url" class="auth-input" name="github_url" type="url"
                                   value="{{ old('github_url', $leader->github_url) }}" />
                            @error('github_url') <div class="auth-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="auth-actions">
                        <button class="btn primary breath" type="submit">{{ $mode === 'edit' ? 'Save' : 'Add' }}</button>
                        <a class="btn secondary" href="{{ route('admin.leaders.index') }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection
