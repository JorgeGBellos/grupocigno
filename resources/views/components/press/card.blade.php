@props([
    'title',
    'excerpt',
    'publication',
    'logo' => null,
    'url' => null,
    'featured' => false,
])

@php
    $paragraphs = preg_split('/\n\s*\n/', trim($excerpt)) ?: [$excerpt];
@endphp

<article class="flex h-full flex-col items-center border border-black-500 px-5 py-8 text-center lg:px-8 lg:py-10 xl:px-10">
    <h2 class="type-h2 min-h-[2.4em] w-full">{{ $title }}</h2>

    <div class="mt-5 flex flex-1 flex-col space-y-4 lg:mt-6">
        @foreach ($paragraphs as $paragraph)
            <p class="type-b3">{{ $paragraph }}</p>
        @endforeach
    </div>

    <div class="mt-8 w-full lg:mt-10">
        @if ($logo)
            @php
                $logoSrc = str_starts_with($logo, 'http') || str_starts_with($logo, '/')
                    ? $logo
                    : asset(str_replace(' ', '%20', $logo));
            @endphp
            <img
                src="{{ $logoSrc }}"
                alt="{{ $publication }}"
                @class([
                    'mx-auto h-auto w-full max-w-[500px]' => $featured,
                    'mx-auto max-h-10 w-auto max-w-full lg:max-h-12' => ! $featured,
                ])
            >
        @else
            <p class="type-s1">{{ $publication }}</p>
        @endif

        @if ($url)
            <x-home.outline-button
                :href="$url"
                class="mt-8 w-full lg:mt-10"
            >
                {{ __('press.read_article') }}
            </x-home.outline-button>
        @else
            <span class="type-btn-md no-underline mt-8 inline-flex w-full items-center justify-center rounded-[14px] border border-yellow-gold-500 px-12 py-3.5 uppercase tracking-[0.08em] text-yellow-gold-500 lg:mt-10">
                {{ __('press.read_article') }}
            </span>
        @endif
    </div>
</article>
