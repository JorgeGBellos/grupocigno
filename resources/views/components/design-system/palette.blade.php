@props([
    'name',
    'shades',
])

<div>
    <p class="type-label">{{ $name }}</p>
    <div class="mt-4 grid gap-4 sm:grid-cols-3">
        @foreach ($shades as $shade)
            <article class="overflow-hidden border border-beige-300">
                <div @class([
                    $shade['swatch'],
                    'flex h-28 items-end p-4',
                    'text-off-white-100' => $shade['light'] ?? false,
                    'text-yellow-gold-500' => ! ($shade['light'] ?? false),
                ])>
                    <span class="type-label">{{ $shade['shade'] }}</span>
                </div>
                <div class="bg-off-white-300 px-4 py-3">
                    <p class="type-b3">{{ $shade['hex'] }}</p>
                    <p class="type-b3 mt-1 text-yellow-gold-300">{{ $shade['token'] }}</p>
                </div>
            </article>
        @endforeach
    </div>
</div>
