@props([
    'layout' => null,
    'hidden' => false,
    'mobile' => null,
    'desktop' => null,
])

@php
    $attributes = $attributes->class([
        'mirai-finder',
        'sr-only' => $hidden,
    ]);
@endphp

<div
    {{ $attributes }}
    data-mirai-component="finder"
    @if ($layout) data-layout="{{ $layout }}" @endif
    @if ($mobile === true) data-mobile="true" @elseif ($mobile === false) data-mobile="false" @endif
    @if ($desktop === true) data-desktop="true" @elseif ($desktop === false) data-desktop="false" @endif
    @if ($hidden) aria-hidden="true" @endif
></div>
