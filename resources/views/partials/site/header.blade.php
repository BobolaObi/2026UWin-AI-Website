<header class="{{ $header_class ?? '' }}" data-reveal>
  <a class="brand" title="Windsor AI Club Logo" href="{{ route('home') }}" data-reveal>
    Windsor AI Club
  </a>
  <nav>
    <a class="{{ request()->routeIs('events') ? 'active' : '' }}" href="{{ route('events') }}" title="View our upcoming events">Events</a>
    <a class="{{ request()->routeIs('leaders') ? 'active' : '' }}" href="{{ route('leaders') }}" title="Meet the group leaders">Leaders</a>
    <a class="{{ request()->routeIs('join') ? 'active' : '' }}" href="{{ route('join') }}" title="Find out how to join the Windsor AI Club">Join</a>
  </nav>

  @auth
    @php
      /** @var \App\Models\User $user */
      $user = auth()->user();
      $role = $user->role ?: \App\Models\User::ROLE_MEMBER;
      $is_staff = in_array($role, [\App\Models\User::ROLE_EDITOR, \App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_SUPER_ADMIN], true);
      $badge_text = strtoupper(str_replace('_', ' ', $role));
    @endphp
    <div class="nav-auth">
      <a class="nav-auth-link" href="{{ route('dashboard') }}">Dashboard</a>
      @if ($is_staff)
        <span class="nav-role-pill nav-role-{{ $role }}">{{ $badge_text }}</span>
      @endif
    </div>
  @endauth
</header>
