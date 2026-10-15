@props([
    'image',
    'title',
    'paragraphs' => [],
    'subtitle' => null,
    'subtitleBody' => null,
    'tag' => null,
    'expandable' => false,
    'cta' => null,
    'ctaHref' => null,
])

@php
    $paragraphs = array_values($paragraphs);
    $previewCount = 2;
@endphp

<article
    class="flex h-full flex-col"
    @if ($expandable)
        x-data="{ open: false }"
    @endif
>
    <div class="aspect-square overflow-hidden bg-beige-300">
        <img
            src="{{ asset($image) }}"
            alt="{{ $title }}"
            class="size-full object-cover"
        >
    </div>

        <h2 class="type-s2 mt-8 text-balance">{{ $title }}</h2>

    <div class="mt-4 flex-1 space-y-4">
        @foreach ($paragraphs as $index => $paragraph)
            <p
                class="type-b3 text-pretty"
                @if ($expandable && $index >= $previewCount)
                    x-show="open"
                    x-cloak
                    x-transition.opacity.duration.200ms
                @endif
            >{{ $paragraph }}</p>
        @endforeach

        @if (filled($subtitle))
            <div
                @if ($expandable)
                    x-show="open"
                    x-cloak
                    x-transition.opacity.duration.200ms
                @endif
            >
                <h3 class="type-b1 mt-2">{{ $subtitle }}</h3>
                @if (filled($subtitleBody))
                    <p class="type-b3 mt-3 text-pretty">{{ $subtitleBody }}</p>
                @endif
            </div>
        @endif
    </div>

    <div class="mt-auto flex flex-col gap-6 pt-8">
        @if ($expandable)
            <button
                type="button"
                class="type-label inline-flex min-h-11 items-center gap-2 self-start py-2 text-blue-ermita-300 transition-opacity duration-300 hover:opacity-40"
                @click="open = ! open"
            >
                <span x-text="open ? {{ \Illuminate\Support\Js::from(__('ermita.experiences_page.see_less')) }} : {{ \Illuminate\Support\Js::from(__('ermita.experiences_page.see_more')) }}"></span>
                <span class="text-sm transition-transform duration-200" :class="open && 'rotate-180'" aria-hidden="true">⌄</span>
            </button>
        @endif

        @if (filled($tag))
            <p class="type-label">{{ $tag }}</p>
        @endif

        @if (filled($cta) && filled($ctaHref))
            <x-ermita.button
                :href="$ctaHref"
                variant="outline-soft"
                class="w-full border-beige-300 px-6 text-blue-ermita-300"
            >
                {{ $cta }}
            </x-ermita.button>
        @endif
    </div>
</article>
