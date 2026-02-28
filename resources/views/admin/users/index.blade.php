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

            @if ($is_actor_super_admin)
                <div class="panel-kicker">Rules</div>
                <ul class="panel-list">
                    <li><strong>Owner:</strong> exactly one; can assign any role.</li>
                    <li><strong>Admin:</strong> can assign Editor roles.</li>
                    <li><strong>Editor:</strong> can manage events.</li>
                </ul>
            @else
                <div class="panel-kicker">Note</div>
                <p class="sub" style="margin:0;">
                    You can assign <strong>editor</strong> access. Protected accounts can’t be changed here.
                </p>
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
                        $is_super = $current_super_admin_id === $user->id || $user->role === \App\Models\User::ROLE_SUPER_ADMIN;
                        $raw_role = $is_super ? \App\Models\User::ROLE_SUPER_ADMIN : ($user->role ?: \App\Models\User::ROLE_MEMBER);
                        $role = (! $is_actor_super_admin && $raw_role === \App\Models\User::ROLE_SUPER_ADMIN)
                            ? \App\Models\User::ROLE_ADMIN
                            : $raw_role;
                        $is_protected = ! $is_actor_super_admin && in_array($raw_role, [\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_SUPER_ADMIN], true);
                    @endphp
                    <div class="admin-row">
                        <div class="admin-title">
                            {{ $user->name }}
                            @if ($is_actor_super_admin && $is_super)
                                <span class="badge badge-live" style="margin-left:10px;">Owner</span>
                            @endif
                        </div>
                        <div class="admin-when">{{ $user->email }}</div>
                        <div>
                            <span class="badge {{ $role === 'member' ? 'badge-draft' : 'badge-live' }}">{{ $role }}</span>
                        </div>
                        <div class="admin-actions">
                            <form method="POST" action="{{ route('admin.users.role', $user) }}">
                                @csrf
                                @method('PATCH')
                                <select class="auth-input" name="role" style="padding:10px 12px; width: 180px;" {{ $is_protected ? 'disabled' : '' }}>
                                    <option value="member" {{ $role === 'member' ? 'selected' : '' }}>member</option>
                                    <option value="editor" {{ $role === 'editor' ? 'selected' : '' }}>editor</option>
                                    @if ($is_actor_super_admin)
                                        <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>admin</option>
                                        <option value="super_admin" {{ $role === 'super_admin' ? 'selected' : '' }}>owner</option>
                                    @endif
                                </select>
                                @if (! $is_protected)
                                    <button class="btn secondary" type="submit">Update</button>
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
