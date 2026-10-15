@props([
    'src',
    'poster' => null,
    'type' => 'video/mp4',
])

@if (config('media.videos_enabled'))
    <video
        {{ $attributes->merge([
            'muted' => true,
            'loop' => true,
            'playsinline' => true,
        ]) }}
        @if (filled($poster)) poster="{{ $poster }}" @endif
    >
        <source src="{{ $src }}" type="{{ $type }}">
    </video>
@else
    <img
        src="{{ $poster ?: $src }}"
        alt=""
        {{ $attributes
            ->except([
                'autoplay',
                'muted',
                'loop',
                'playsinline',
                'preload',
                'poster',
                'data-managed',
                'data-carousel-video',
            ])
            ->merge(['draggable' => 'false']) }}
    >
@endif
