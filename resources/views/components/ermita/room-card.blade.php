@props([
    'image',
    'title',
    'body',
    'people',
    'beds',
    'infoHref' => null,
    'reserveHref' => null,
])

@php
    $infoHref = $infoHref ?: route('cigno-ermita.rooms');
    $reserveHref = $reserveHref ?: route('cigno-ermita').'#booking';
@endphp

<article class="flex h-full flex-col">
    <div class="aspect-[16/11] overflow-hidden bg-beige-300">
        <img
            src="{{ asset($image) }}"
            alt="{{ $title }}"
            class="size-full object-cover"
        >
    </div>

    <div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-3">
        <span class="type-label inline-flex items-center gap-3 text-black-500">
            <img
                src="{{ asset('images/ermita/Component 1 (7).svg') }}"
                alt=""
                width="44"
                height="44"
                class="size-11 shrink-0"
            >
            {{ $people === 1
                ? __('ermita.rooms.max_people_one')
                : __('ermita.rooms.max_people', ['count' => $people]) }}
        </span>
        <span class="type-label inline-flex items-center gap-3 text-black-500">
            <img
                src="{{ asset('images/ermita/Component 1 (6).svg') }}"
                alt=""
                width="44"
                height="44"
                class="size-11 shrink-0"
            >
            {{ $beds === 1
                ? __('ermita.rooms.beds_one')
                : __('ermita.rooms.beds_other', ['count' => $beds]) }}
        </span>
    </div>

    <h2 class="type-h2 mt-6 text-balance">{{ $title }}</h2>
    <p class="type-b3 mt-4 flex-1 text-pretty">{{ $body }}</p>

    <div class="mt-8 flex flex-col gap-3">
        <x-ermita.button :href="$infoHref" variant="outline" class="w-full px-6">
            {{ __('ermita.rooms_page.more_info') }}
        </x-ermita.button>

        <x-ermita.button :href="$reserveHref" class="w-full px-6">
            {{ __('ermita.rooms_page.reserve') }}
        </x-ermita.button>
    </div>
</article>
