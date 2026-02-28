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

            <div class="panel-kicker">Notes</div>
            <ul class="panel-list">
                <li><strong>Admin:</strong> can assign Editor roles.</li>
                <li><strong>Editor:</strong> can manage events.</li>
            </ul>

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
                        $is_protected = ! $is_actor_super_admin && $role === \App\Models\User::ROLE_ADMIN;
                        $is_locked_row = $is_protected || ($is_actor_super_admin && $is_primary_admin);
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
                            <form method="POST" action="{{ route('admin.users.role', $user) }}">
                                @csrf
                                @method('PATCH')
                                <select class="auth-input" name="role" style="padding:10px 12px; width: 200px;" {{ $is_locked_row ? 'disabled' : '' }} data-role-select>
                                    <option value="member" {{ $role === 'member' ? 'selected' : '' }}>member</option>
                                    <option value="editor" {{ $role === 'editor' ? 'selected' : '' }}>editor</option>
                                    @if ($is_actor_super_admin)
                                        <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>admin</option>
                                        @if (! $is_primary_admin)
                                            <option value="primary_admin">make primary admin</option>
                                        @endif
                                    @endif
                                </select>
                                @if ($is_actor_super_admin && ! $is_locked_row)
                                    <input class="auth-input" type="password" name="password" placeholder="Confirm your password" style="display:none; width: 220px;" data-transfer-password />
                                @endif
                                @if (! $is_locked_row)
                                    <button class="btn secondary" type="submit" data-role-submit>Update</button>
                                @endif
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('form').forEach((form) => {
            const select = form.querySelector('[data-role-select]');
            const password = form.querySelector('[data-transfer-password]');
            const submit = form.querySelector('[data-role-submit]');
            if (!select || !password || !submit) return;

            function sync() {
                const transferring = select.value === 'primary_admin';
                password.style.display = transferring ? 'inline-block' : 'none';
                password.required = transferring;
                if (!transferring) password.value = '';
                submit.textContent = transferring ? 'Transfer' : 'Update';
            }

            select.addEventListener('change', sync);
            sync();
        });
    </script>
@endpush
