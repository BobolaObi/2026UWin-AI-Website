<header class="{{ $header_class ?? '' }}" data-reveal>
  <a class="brand" title="Windsor AI Club Logo" href="{{ route('home') }}" data-reveal>
    Windsor AI Club
  </a>
  <nav>
    <a class="{{ request()->routeIs('events') ? 'active' : '' }}" href="{{ route('events') }}" title="View our upcoming events">Events</a>
    <a class="{{ request()->routeIs('leaders') ? 'active' : '' }}" href="{{ route('leaders') }}" title="Meet the group leaders">Leaders</a>
    <a class="{{ request()->routeIs('join') ? 'active' : '' }}" href="{{ route('join') }}" title="Find out how to join the Windsor AI Club">Join</a>
  </nav>
</header>
