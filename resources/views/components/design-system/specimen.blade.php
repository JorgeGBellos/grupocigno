@props([
    'type',
    'token',
    'meta',
    'sample',
])

<article class="border-b border-beige-300 py-8 last:border-b-0">
    <p class="type-label">{{ $token }}</p>
    <p class="type-b3 mt-2 text-yellow-gold-300">{{ $meta }}</p>
    <div @class([$type, 'mt-6'])>{{ $sample }}</div>
</article>
