@props([
    'iconClass' => 'size-10',
])

<div {{ $attributes->class(['flex items-center gap-6']) }}>
    <a href="{{ route('contact') }}" class="transition-opacity duration-300 hover:opacity-40" aria-label="{{ __('ui.call') }}">
        <img
            src="{{ asset('images/footer/llamada.svg') }}"
            alt=""
            width="40"
            height="40"
            @class([$iconClass])
        >
    </a>
    <a href="#" class="transition-opacity duration-300 hover:opacity-40" aria-label="{{ __('ui.instagram') }}" rel="noopener noreferrer">
        <img
            src="{{ asset('images/footer/ig.svg') }}"
            alt=""
            width="40"
            height="40"
            @class([$iconClass])
        >
    </a>
</div>
