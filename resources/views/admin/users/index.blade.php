@extends('layouts.site')

@section('title', 'Admin Users | Windsor AI Club')
@section('body_class', 'events-page admin-page')

@section('content')
    <div class="events-hero">
        @include('partials.site.header', ['header_class' => 'events-nav'])
        <div class="events-hero-content" data-reveal>
            <a class="back-link" href="{{ route('dashboard') }}" data-reveal>← Back</a>
            <h1 data-reveal>Admin · Users</h1>
            <p class="events-season" data-reveal>Roles and access</p>
        </div>
    </div>

    <div class="events-shell">
        <div class="panel-card panel-card-wide" data-reveal>
            @if (session('status'))
                <div class="auth-status">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="auth-error" style="margin: 0 0 12px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="admin-table">
                <div class="admin-row admin-head">
                    <div>User</div>
                    <div>Email</div>
                    <div>Role</div>
                    <div></div>
                </div>

                @foreach ($users as $user)
                    @php
                        $is_primary_admin = $current_super_admin_id === $user->id;
                        $raw_role = $user->role ?: \App\Models\User::ROLE_MEMBER;
                        $role = $raw_role === \App\Models\User::ROLE_SUPER_ADMIN ? \App\Models\User::ROLE_ADMIN : $raw_role;
                        $is_locked_row = $is_actor_super_admin && $is_primary_admin;
                    @endphp
                    <div class="admin-row">
                        <div class="admin-title">
                            {{ $user->name }}
                        </div>
                        <div class="admin-when">{{ $user->email }}</div>
                        <div>
                            <span class="badge {{ $role === 'member' ? 'badge-draft' : 'badge-live' }}">{{ $role }}</span>
                        </div>
                        <div class="admin-actions">
                            @if ($is_actor_super_admin)
                                <form method="POST" action="{{ route('admin.users.role', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select class="auth-input" name="role" style="padding:10px 12px; width: 200px;" {{ $is_locked_row ? 'disabled' : '' }} data-role-select>
                                        <option value="member" {{ $role === 'member' ? 'selected' : '' }}>member</option>
                                        <option value="editor" {{ $role === 'editor' ? 'selected' : '' }}>editor</option>
                                        <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>admin</option>
                                    </select>
                                    @if (! $is_locked_row)
                                        <button class="btn secondary" type="submit" data-role-submit>Update</button>
                                    @endif
                                </form>
                                @if (! $is_locked_row)
                                    <form method="POST" action="{{ route('admin.users.role', $user) }}" style="display:flex; gap:8px; flex-wrap:wrap;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="role" value="super_admin" />
                                        <input class="auth-input" type="password" name="password" placeholder="Confirm your password" style="display:none; width: 220px;" data-transfer-password />
                                        <button class="btn secondary" type="submit" data-transfer-submit>Make super admin</button>
                                    </form>
                                @endif
                            @else
                                <span class="admin-when">—</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection

@if ($is_actor_super_admin)
    @push('scripts')
        <script>
            document.querySelectorAll('[data-transfer-submit]').forEach((button) => {
                const form = button.closest('form');
                if (!form) return;
                const password = form.querySelector('[data-transfer-password]');
                if (!password) return;

                button.addEventListener('click', (e) => {
                    if (password.style.display === 'none' || password.style.display === '') {
                        e.preventDefault();
                        password.style.display = 'inline-block';
                        password.required = true;
                        password.focus();
                    }
                });
            });
        </script>
    @endpush
@endif
