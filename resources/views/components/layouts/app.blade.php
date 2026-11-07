<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name') }}</title>

        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
        <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">

        @if (filled($gaId = config('services.google.analytics_id')))
            {{-- Google tag (gtag.js) --}}
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());
                gtag('config', @js($gaId));
            </script>
        @endif

        {{-- Mirai Core --}}
        <link rel="stylesheet" href="{{ asset('core-variables.css') }}" type="text/css" media="all">
        <link
            rel="preload"
            as="style"
            href="https://static.mirai.com/core/index.css"
            onload="this.onload=null;this.rel='stylesheet'"
        >
        <noscript>
            <link rel="stylesheet" href="https://static.mirai.com/core/index.css">
        </noscript>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    @php
        $hasBranchRow = true;

        $miraiChainId = (string) config('booking.idchain');
        $miraiHotelId = null;
        if (request()->routeIs('cigno-ermita*')) {
            $miraiHotelId = (string) config('booking.hotels.cigno-ermita.mirai_id');
        } elseif (request()->routeIs('cigno-mejorada*')) {
            $miraiHotelId = (string) config('booking.hotels.cigno-mejorada.mirai_id');
        }
        // En home/hoteles el finder visible vive en #booking; en el resto va oculto aquí.
        $miraiFinderVisibleOnPage = request()->routeIs('home', 'cigno-ermita', 'cigno-mejorada');
    @endphp
    <body @class([
        'flex min-h-screen flex-col bg-off-white-100 font-sans antialiased text-neutral-900',
        'has-branch-row' => $hasBranchRow,
    ])>
        <div
            data-mirai-id="{{ $miraiChainId }}"
            data-type="chain"
            @if ($miraiHotelId) data-hotel="{{ $miraiHotelId }}" @endif
        ></div>

        <x-layouts.header />

        <div class="flex flex-1 flex-col">
            {{ $slot }}
        </div>

        <x-layouts.footer />

        @unless ($miraiFinderVisibleOnPage)
            <x-mirai.finder layout="expand" :hidden="true" />
        @endunless
        <div data-mirai-component="session" class="sr-only" aria-hidden="true"></div>

        @livewireScripts

        <script
            type="module"
            src="https://static.mirai.com/core/index.js"
            data-cookieconsent="necessary"
        ></script>
    </body>
</html>
