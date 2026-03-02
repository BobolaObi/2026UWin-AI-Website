<header class="{{ $header_class ?? '' }}" data-reveal>
  <a class="brand" title="Windsor AI Club Logo" href="{{ route('home') }}" data-reveal>
    Windsor AI Club
  </a>
  <nav class="site-nav" aria-label="Primary navigation">
    <a class="{{ request()->routeIs('events') ? 'active' : '' }}" href="{{ route('events') }}" title="View our upcoming events">Events</a>
    <a class="{{ request()->routeIs('leaders') ? 'active' : '' }}" href="{{ route('leaders') }}" title="Meet the group leaders">Leaders</a>
    <a class="{{ request()->routeIs('join') ? 'active' : '' }}" href="{{ route('join') }}" title="Find out how to join the Windsor AI Club">Join</a>
  </nav>

  <button
    class="nav-toggle"
    type="button"
    aria-label="Menu"
    aria-controls="mobileNav"
    aria-expanded="false"
    data-nav-toggle
  >
    <span aria-hidden="true"></span>
    <span aria-hidden="true"></span>
    <span aria-hidden="true"></span>
    <span class="nav-toggle-label">Menu</span>
  </button>

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
        <span class="nav-role-pill nav-role-admin">{{ $badge_text }}</span>
      @endif
    </div>
  @endauth

  <div class="mobile-nav" id="mobileNav" hidden>
    <div class="mobile-nav-backdrop" data-nav-close></div>
    <div class="mobile-nav-panel" role="dialog" aria-modal="true" aria-label="Menu">
      <div class="mobile-nav-header">
        <span class="mobile-nav-title">Menu</span>
        <button class="mobile-nav-close" type="button" aria-label="Close menu" data-nav-close>×</button>
      </div>
      <nav class="mobile-nav-links" aria-label="Mobile navigation">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('events') }}">Events</a>
        <a href="{{ route('leaders') }}">Leaders</a>
        <a href="{{ route('join') }}">Join</a>
        @auth
          <a href="{{ route('dashboard') }}">Dashboard</a>
        @endauth
      </nav>
    </div>
  </div>
</header>
