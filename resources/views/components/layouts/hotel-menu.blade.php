@props([
    'items',
    'linkClass' => 'type-h3',
    'align' => 'start',
])

@php
    $columns = array_chunk($items, (int) ceil(max(count($items), 1) / 2));
    $listAlign = $align === 'center' ? 'items-center' : 'items-start';
@endphp

<div {{ $attributes->class(['grid grid-cols-1 gap-y-2 sm:grid-cols-2 sm:gap-x-10 lg:gap-x-16']) }}>
    @foreach ($columns as $column)
        <ul class="flex flex-col {{ $listAlign }} gap-5">
            @foreach ($column as $item)
                <li>
                    <a
                        href="{{ route($item['route']) }}"
                        class="{{ $linkClass }} transition-opacity duration-300 hover:opacity-40"
                        @click="menuOpen = false"
                        @if (request()->routeIs($item['route']))
                            aria-current="page"
                        @endif
                    >{{ __($item['label']) }}</a>
                </li>
            @endforeach

            @if ($loop->last)
                <li>
                    <x-social-links class="mt-1" icon-class="size-8" />
                </li>
            @endif
        </ul>
    @endforeach
</div>
