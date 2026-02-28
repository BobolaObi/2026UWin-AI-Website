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
        <div class="panel-card" data-reveal>
            @if (session('status'))
                <div class="auth-status">{{ session('status') }}</div>
            @endif

            <div class="panel-kicker">Rules</div>
            <ul class="panel-list">
                <li><strong>Super Admin:</strong> exactly one; can assign any role.</li>
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
                        $is_super = $current_super_admin_id === $user->id || $user->role === \App\Models\User::ROLE_SUPER_ADMIN;
                        $role = $is_super ? \App\Models\User::ROLE_SUPER_ADMIN : ($user->role ?: \App\Models\User::ROLE_MEMBER);
                    @endphp
                    <div class="admin-row">
                        <div class="admin-title">
                            {{ $user->name }}
                            @if ($is_super)
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
                                <select class="auth-input" name="role" style="padding:10px 12px; width: 180px;">
                                    <option value="member" {{ $role === 'member' ? 'selected' : '' }}>member</option>
                                    <option value="editor" {{ $role === 'editor' ? 'selected' : '' }}>editor</option>
                                    <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>admin</option>
                                    <option value="super_admin" {{ $role === 'super_admin' ? 'selected' : '' }}>super_admin</option>
                                </select>
                                <button class="btn secondary" type="submit">Update</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('partials.site.footer', ['footer_class' => 'dark-footer'])
@endsection

