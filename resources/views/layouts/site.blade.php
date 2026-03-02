<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Windsor AI Club')</title>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @php
      $style_version = file_exists(public_path('style.css')) ? filemtime(public_path('style.css')) : null;
      $app_version = file_exists(public_path('app.js')) ? filemtime(public_path('app.js')) : null;
    @endphp
    <link rel="stylesheet" href="{{ asset('style.css') }}{{ $style_version ? '?v='.$style_version : '' }}">
    <script src="{{ asset('app.js') }}{{ $app_version ? '?v='.$app_version : '' }}" defer></script>
    @stack('head')
  </head>
  <body class="@yield('body_class')">
    @yield('content')
    @stack('scripts')
  </body>
</html>
