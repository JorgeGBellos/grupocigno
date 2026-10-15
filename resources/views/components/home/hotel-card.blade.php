@props([
    'image',
    'name',
    'route',
    'cta',
])

<article class="flex flex-col items-center text-center">
    <img
        src="{{ filter_var($image, FILTER_VALIDATE_URL) || str_starts_with($image, '/storage/') ? $image : asset($image) }}"
        alt="{{ $name }}"
        class="aspect-[790/417] w-full object-cover"
    >

    <h3 class="type-h3 mt-8">{{ $name }}</h3>

    <x-home.outline-button
        :href="route($route)"
        class="mt-6 w-full"
    >
        {{ $cta }}
    </x-home.outline-button>
</article>
