@props(['icon', 'label'])

<div {{ $attributes->merge(['class' => 'flex min-w-0 items-center gap-3 text-left text-black-500']) }}>
    <img
        src="{{ asset('images/home/form/'.$icon) }}"
        alt=""
        width="44"
        height="44"
        class="size-11 shrink-0"
    >
    <div class="flex min-w-0 flex-1 flex-col">
        <span class="type-btn-sm no-underline">{{ $label }}</span>
        {{ $slot }}
    </div>
</div>
