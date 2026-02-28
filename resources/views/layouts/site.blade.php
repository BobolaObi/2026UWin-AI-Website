<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Windsor AI Club')</title>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <script src="{{ asset('app.js') }}" defer></script>
    @stack('head')
  </head>
  <body class="@yield('body_class')">
    @yield('content')
    @stack('scripts')
  </body>
</html>
