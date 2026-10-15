<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name') }}</title>

        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
        <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    @php
        $hasBranchRow = collect(config('navigation.brands'))->contains(
            fn (array $brand): bool => filled($brand['match'] ?? null) && request()->routeIs($brand['match'])
        );
    @endphp
    <body @class([
        'flex min-h-screen flex-col bg-off-white-100 font-sans antialiased text-neutral-900',
        'has-branch-row' => $hasBranchRow,
    ])>
        <x-layouts.header />

        <div class="flex flex-1 flex-col">
            {{ $slot }}
        </div>

        <x-layouts.footer />

        @livewireScripts
    </body>
</html>
