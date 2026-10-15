@php
    $activeBrand = collect(config('navigation.brands'))
        ->first(fn (array $brand): bool => filled($brand['match'] ?? null) && request()->routeIs($brand['match']))
        ?? collect(config('navigation.brands'))->firstWhere('key', 'main');

    $menuKey = $activeBrand['menu'] ?? 'main';
    $items = config('navigation.'.$menuKey, []);

    // Desktop: general menu 2 columns (3+2). Hotel menus: pairs.
    $chunkSize = $menuKey === 'main' ? 3 : 2;
    $columns = array_chunk($items, $chunkSize);

    $contactRoute = collect($items)->last(
        fn (array $item): bool => str_contains($item['route'], 'contact') || ($item['label'] ?? '') === 'nav.contact'
    )['route'] ?? 'contact';
@endphp

<footer class="bg-off-white-500 text-black-500">
    {{-- Mobile: icon + stacked menu + social (matches hotel footer reference) --}}
    <div class="mx-auto flex max-w-[105rem] flex-col items-center px-6 py-14 sm:px-8 lg:hidden">
        <img
            src="{{ asset('images/footer/Swan.svg') }}"
            alt=""
            width="120"
            class="h-auto w-[100px]"
        >

        <nav aria-label="{{ __('ui.footer_nav') }}" class="mt-10 w-full">
            <ul class="flex flex-col items-center gap-4 text-center">
                @foreach ($items as $item)
                    <li>
                        <a
                            href="{{ isset($item['hash']) ? route($item['route']).'#'.$item['hash'] : route($item['route']) }}"
                            class="type-s2 transition-opacity duration-300 hover:opacity-40"
                            @if (request()->routeIs($item['route']) && blank($item['hash'] ?? null))
                                aria-current="page"
                            @endif
                        >{{ __($item['label']) }}</a>
                    </li>
                @endforeach
            </ul>

            <div class="mt-8 flex items-center justify-center gap-5">
                <a
                    href="{{ route($contactRoute) }}"
                    class="transition-opacity duration-300 hover:opacity-40"
                    aria-label="{{ __('ui.call') }}"
                >
                    <img
                        src="{{ asset('images/footer/llamada.svg') }}"
                        alt=""
                        class="size-7"
                    >
                </a>
                <a
                    href="#"
                    class="transition-opacity duration-300 hover:opacity-40"
                    aria-label="{{ __('ui.instagram') }}"
                    rel="noopener noreferrer"
                >
                    <img
                        src="{{ asset('images/footer/ig.svg') }}"
                        alt=""
                        class="size-7"
                    >
                </a>
            </div>
        </nav>
    </div>

    {{-- Desktop: swan + multi-column nav --}}
    <div class="mx-auto hidden max-w-[105rem] flex-row items-center justify-between gap-16 px-12 py-16 lg:flex">
        <div class="flex shrink-0 justify-start">
            <img
                src="{{ asset('images/footer/Swan.svg') }}"
                alt=""
                width="140"
                class="h-auto w-[140px]"
            >
        </div>

        <nav aria-label="{{ __('ui.footer_nav') }}" class="w-auto self-center">
            <div class="flex flex-wrap justify-end gap-x-14 xl:gap-x-16">
                @foreach ($columns as $column)
                    <ul class="flex min-w-[7.5rem] flex-col items-end gap-5 text-right">
                        @foreach ($column as $item)
                            <li>
                                <a
                                    href="{{ isset($item['hash']) ? route($item['route']).'#'.$item['hash'] : route($item['route']) }}"
                                    class="type-s2 transition-opacity duration-300 hover:opacity-40"
                                    @if (request()->routeIs($item['route']) && blank($item['hash'] ?? null))
                                        aria-current="page"
                                    @endif
                                >{{ __($item['label']) }}</a>
                            </li>
                        @endforeach

                        @if ($loop->last)
                            <li class="pt-1">
                                <div class="flex items-center justify-end gap-5">
                                    <a
                                        href="{{ route($contactRoute) }}"
                                        class="transition-opacity duration-300 hover:opacity-40"
                                        aria-label="{{ __('ui.call') }}"
                                    >
                                        <img
                                            src="{{ asset('images/footer/llamada.svg') }}"
                                            alt=""
                                            class="size-7"
                                        >
                                    </a>
                                    <a
                                        href="#"
                                        class="transition-opacity duration-300 hover:opacity-40"
                                        aria-label="{{ __('ui.instagram') }}"
                                        rel="noopener noreferrer"
                                    >
                                        <img
                                            src="{{ asset('images/footer/ig.svg') }}"
                                            alt=""
                                            class="size-7"
                                        >
                                    </a>
                                </div>
                            </li>
                        @endif
                    </ul>
                @endforeach
            </div>
        </nav>
    </div>

    {{-- Partner logos (desktop) --}}
    <div class="hidden border-t border-black-500 lg:block">
        <div class="mx-auto flex max-w-[105rem] flex-wrap items-center justify-center gap-x-20 gap-y-8 px-12 py-12">
            <img
                src="{{ asset('images/footer/cigno.png') }}"
                alt="Cigno"
                class="h-9 w-auto object-contain object-center"
            >
            <img
                src="{{ asset('images/footer/amate61.png') }}"
                alt="Casa Amate 61"
                class="h-9 w-auto object-contain object-center"
            >
            <img
                src="{{ asset('images/footer/totem.png') }}"
                alt="Tōtem"
                class="h-9 w-auto object-contain object-center"
            >
            <img
                src="{{ asset('images/footer/amate62.png') }}"
                alt="Casa Amate 62"
                class="h-9 w-auto object-contain object-center"
            >
        </div>
    </div>

    {{-- Black Swan + legales --}}
    <div class="border-t border-black-500">
        <div class="mx-auto flex max-w-[105rem] flex-col items-center gap-6 px-6 py-8 lg:flex-row lg:justify-between lg:px-12 lg:py-10">
            <img
                src="{{ asset('images/footer/black.svg') }}"
                alt="Black Swan"
                class="h-8 w-auto lg:h-9"
            >

            <nav
                aria-label="{{ __('ui.legal_nav') }}"
                class="flex flex-wrap items-center justify-center gap-x-5 gap-y-3 sm:gap-x-8 lg:gap-x-10"
            >
                <a href="{{ route('legal-notice') }}" class="type-label uppercase transition-opacity duration-300 hover:opacity-40">{{ __('pages.legal_notice') }}</a>
                <a href="{{ route('cookies-policy') }}" class="type-label uppercase transition-opacity duration-300 hover:opacity-40">{{ __('pages.cookies_policy') }}</a>
                <a href="{{ route('cookie-settings') }}" class="type-label uppercase transition-opacity duration-300 hover:opacity-40">{{ __('pages.cookie_settings') }}</a>
            </nav>
        </div>
    </div>
</footer>
