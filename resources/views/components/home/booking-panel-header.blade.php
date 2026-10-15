@props([
    'icon',
    'label',
    'position' => 'bottom',
])

<div {{ $attributes->merge(['class' => 'flex items-center justify-between px-5 py-4 '.($position === 'top' ? 'border-b border-black-500' : 'border-t border-black-500')]) }}>
    <div class="flex min-w-0 items-center gap-3">
        <img
            src="{{ asset('images/home/form/'.$icon) }}"
            alt=""
            width="44"
            height="44"
            class="size-11 shrink-0"
        >
        <span class="type-btn-md no-underline uppercase">{{ $label }}</span>
    </div>

    <button
        type="button"
        class="shrink-0 transition-opacity duration-300 hover:opacity-40"
        @click="panel = null"
        aria-label="{{ __('ui.close_menu') }}"
    >
        <img
            src="{{ asset('images/header/close.svg') }}"
            alt=""
            width="24"
            height="24"
            class="size-6"
        >
    </button>
</div>
