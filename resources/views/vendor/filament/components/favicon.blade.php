@props(['favicon' => null])

<link rel="icon" href="{{ $favicon ?? asset('favicon.ico') }}" type="image/svg+xml">
<link rel="alternate icon" href="{{ asset('favicon.ico') }}">
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
