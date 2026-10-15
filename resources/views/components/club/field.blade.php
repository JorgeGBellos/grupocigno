@props([
    'name',
    'label',
    'required' => true,
    'labelClass' => 'type-b2 text-black-500',
])

<div {{ $attributes }}>
    <label for="club-{{ $name }}" class="{{ $labelClass }}">
        {{ $label }}@if ($required)<span aria-hidden="true">*</span>@endif
    </label>
    <div class="mt-2">
        {{ $slot }}
    </div>
</div>
