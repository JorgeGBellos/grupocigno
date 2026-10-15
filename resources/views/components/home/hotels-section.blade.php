@php
    $title = $cms->text('hotels.title', 'home.hotels.title');
    $videosEnabled = config('media.videos_enabled');
    $ermitaPoster = $cms->asset('hotels.ermita_background', 'images/home/Ermitaback.png');
    $mejoradaPoster = $cms->asset('hotels.mejorada_background', 'images/home/mejoradaback.png');
    $ermitaVideo = $cms->asset('hotels.ermita_video', 'videos/padel.mp4');
    $mejoradaVideo = $cms->asset('hotels.mejorada_video', 'videos/agua.mp4');
@endphp

<section class="relative isolate grid min-h-[min(100svh,56rem)] grid-cols-1 lg:min-h-[48rem] lg:grid-cols-2" aria-label="{{ $title }}">
    <h2 class="type-s2 pointer-events-none absolute inset-x-0 top-10 z-20 px-6 text-center text-white lg:top-14">
        {{ $title }}
    </h2>

    <a
        href="{{ route('cigno-ermita') }}"
        class="group relative flex min-h-[28rem] flex-col items-center justify-between overflow-hidden px-8 py-16 text-center text-white lg:min-h-0 lg:px-12 lg:py-20"
        @if ($videosEnabled)
            x-data="hoverVideo"
            @mouseenter="start()"
            @mouseleave="stop()"
            @focusin="start()"
            @focusout="stop()"
        @endif
    >
        <img
            src="{{ $ermitaPoster }}"
            alt=""
            class="absolute inset-0 size-full object-cover transition-transform duration-700 group-hover:scale-[1.03]"
        >

        @if ($videosEnabled)
            <video
                x-ref="video"
                class="pointer-events-none absolute inset-0 size-full object-cover opacity-0 transition-opacity duration-500"
                :class="{ 'opacity-100': active }"
                muted
                loop
                playsinline
                preload="none"
                data-src="{{ $ermitaVideo }}"
                poster="{{ $ermitaPoster }}"
                aria-hidden="true"
            ></video>
        @endif

        <div class="relative z-10 flex flex-1 flex-col items-center justify-center pt-16 lg:pt-20">
            <img
                src="{{ $cms->asset('hotels.ermita_logo', 'images/home/Logotipo.svg') }}"
                alt="{{ __('nav.ermita') }}"
                width="420"
                class="h-auto w-full max-w-[280px] sm:max-w-[340px] lg:max-w-[420px]"
            >

            <img
                src="{{ asset('images/ermita/michelin.svg') }}"
                alt="{{ __('nav.michelin_2025') }}"
                height="20"
                class="mt-6 h-5 w-auto"
            >
        </div>

        <span class="type-btn-sm relative z-10 mt-10 inline-flex w-full max-w-md items-center justify-center rounded-[14px] border border-white bg-white px-6 py-4 text-blue-ermita-300 no-underline uppercase transition-colors duration-300 group-hover:border-blue-ermita-100 group-hover:bg-blue-ermita-100 group-hover:text-white">
            {{ __('home.hotels.explore_ermita') }}
        </span>
    </a>

    <a
        href="{{ route('cigno-mejorada') }}"
        class="group relative flex min-h-[28rem] flex-col items-center justify-between overflow-hidden px-8 py-16 text-center text-white lg:min-h-0 lg:px-12 lg:py-20"
        @if ($videosEnabled)
            x-data="hoverVideo"
            @mouseenter="start()"
            @mouseleave="stop()"
            @focusin="start()"
            @focusout="stop()"
        @endif
    >
        <img
            src="{{ $mejoradaPoster }}"
            alt=""
            class="absolute inset-0 size-full object-cover transition-transform duration-700 group-hover:scale-[1.03]"
        >

        @if ($videosEnabled)
            <video
                x-ref="video"
                class="pointer-events-none absolute inset-0 size-full object-cover opacity-0 transition-opacity duration-500"
                :class="{ 'opacity-100': active }"
                muted
                loop
                playsinline
                preload="none"
                data-src="{{ $mejoradaVideo }}"
                poster="{{ $mejoradaPoster }}"
                aria-hidden="true"
            ></video>
        @endif

        <div class="relative z-10 flex flex-1 flex-col items-center justify-center pt-16 lg:pt-20">
            <img
                src="{{ $cms->asset('hotels.mejorada_logo', 'images/home/mejorada.svg') }}"
                alt="{{ __('nav.mejorada') }}"
                width="420"
                class="h-auto w-full max-w-[280px] sm:max-w-[340px] lg:max-w-[420px]"
            >
        </div>

        <span class="type-btn-sm relative z-10 mt-10 inline-flex w-full max-w-md items-center justify-center rounded-[14px] border border-white bg-white px-6 py-4 text-blue-mejorada-300 no-underline uppercase transition-colors duration-300 group-hover:border-blue-mejorada-100 group-hover:bg-blue-mejorada-100 group-hover:text-white">
            {{ __('home.hotels.explore_mejorada') }}
        </span>
    </a>
</section>
