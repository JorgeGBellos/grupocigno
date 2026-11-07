@php
    $activeBrand = collect(config('navigation.brands'))
        ->first(fn (array $brand): bool => filled($brand['match'] ?? null) && request()->routeIs($brand['match']))
        ?? collect(config('navigation.brands'))->firstWhere('key', 'main');

    $menuKey = $activeBrand['menu'] ?? 'main';
    $items = config('navigation.'.$menuKey, []);

    $contactRoute = collect($items)->last(
        fn (array $item): bool => str_contains($item['route'], 'contact') || ($item['label'] ?? '') === 'nav.contact'
    )['route'] ?? 'contact';

    $brandKey = $activeBrand['key'] ?? 'main';
    $instagramUrl = config('social.instagram.'.$brandKey) ?? config('social.instagram.main');
    $phone = config('social.phone.'.$brandKey);
    $phoneHref = filled($phone)
        ? 'tel:'.preg_replace('/\D+/', '', (string) $phone)
        : route($contactRoute);
@endphp

<footer class="bg-off-white-500 text-black-500">
    {{-- Mobile: icon + stacked menu + social --}}
    <div class="site-shell flex flex-col items-center px-[var(--site-gutter)] py-14 lg:hidden">
        <img
            src="{{ asset('images/footer/Swan.svg') }}"
            alt=""
            width="120"
            class="h-auto w-[100px]"
        >

        <nav aria-label="{{ __('ui.footer_nav') }}" class="mt-10 w-full">
            <ul class="flex flex-col items-center gap-4 text-center">
                @foreach ($items as $item)
                    @php
                        if (filled($item['url'] ?? null)) {
                            $itemHref = url($item['url']);
                        } else {
                            $itemHref = route($item['route'], $item['params'] ?? []);
                            if (filled($item['hash'] ?? null)) {
                                $itemHref .= '#'.$item['hash'];
                            }
                        }
                    @endphp
                    <li>
                        <a
                            href="{{ $itemHref }}"
                            class="type-s2 transition-opacity duration-300 hover:opacity-40"
                            @if (filled($item['route'] ?? null) && blank($item['hash'] ?? null) && blank($item['url'] ?? null) && request()->routeIs($item['route']))
                                aria-current="page"
                            @endif
                        >{{ __($item['label']) }}</a>
                    </li>
                @endforeach
            </ul>

            <div class="mt-8 flex items-center justify-center gap-5">
                <a
                    href="{{ $phoneHref }}"
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
                    href="{{ $instagramUrl }}"
                    class="transition-opacity duration-300 hover:opacity-40"
                    aria-label="{{ __('ui.instagram') }}"
                    target="_blank"
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

    {{-- Desktop: centered swan --}}
    <div class="site-shell hidden justify-center px-[var(--site-gutter)] py-16 lg:flex">
        <img
            src="{{ asset('images/footer/Swan.svg') }}"
            alt=""
            width="140"
            class="h-auto w-[140px]"
        >
    </div>

    {{-- Partner logos (desktop): una sola fila, escala con el ancho --}}
    <div class="hidden border-y border-black-500 lg:block">
        <div class="site-shell flex items-center justify-center gap-[50px] px-[var(--site-gutter)] py-6 xl:py-8">
            <img
                src="{{ asset('images/footer/cigno.png') }}"
                alt="Cigno"
                class="h-[clamp(1rem,1.35vw,1.5rem)] w-auto shrink-0"
            >
            <img
                src="{{ asset('images/footer/amate61.png') }}"
                alt="Casa Amate 61"
                class="h-[clamp(1rem,1.35vw,1.5rem)] w-auto shrink-0"
            >
            <img
                src="{{ asset('images/footer/totem.png') }}"
                alt="Tōtem"
                class="h-[clamp(1rem,1.35vw,1.5rem)] w-auto shrink-0"
            >
            <img
                src="{{ asset('images/footer/amate62.png') }}"
                alt="Casa Amate 62"
                class="h-[clamp(1rem,1.35vw,1.5rem)] w-auto shrink-0"
            >
        </div>
    </div>

    {{-- Black Swan + legales (+ social on desktop) --}}
    <div class="border-t border-black-500 lg:border-t-0">
        <div class="site-shell flex flex-col items-center gap-6 px-[var(--site-gutter)] py-8 lg:grid lg:grid-cols-3 lg:items-center lg:gap-8 lg:py-10">
            <img
                src="{{ asset('images/footer/black.svg') }}"
                alt="Black Swan"
                class="h-8 w-auto lg:h-9 lg:justify-self-start"
            >

            <nav
                aria-label="{{ __('ui.legal_nav') }}"
                class="flex flex-nowrap items-center justify-center gap-x-4 whitespace-nowrap sm:gap-x-6 lg:gap-x-8"
            >
                <a href="{{ route('legal-notice') }}" class="type-label uppercase transition-opacity duration-300 hover:opacity-40">{{ __('pages.legal_notice') }}</a>
                <a href="{{ route('cookies-policy') }}" class="type-label uppercase transition-opacity duration-300 hover:opacity-40">{{ __('pages.cookies_policy') }}</a>
                <a href="{{ route('cookie-settings') }}" class="type-label uppercase transition-opacity duration-300 hover:opacity-40">{{ __('pages.cookie_settings') }}</a>
            </nav>

            <div class="hidden items-center justify-end gap-5 lg:flex lg:justify-self-end">
                <a
                    href="{{ $phoneHref }}"
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
                    href="{{ $instagramUrl }}"
                    class="transition-opacity duration-300 hover:opacity-40"
                    aria-label="{{ __('ui.instagram') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <img
                        src="{{ asset('images/footer/ig.svg') }}"
                        alt=""
                        class="size-7"
                    >
                </a>
            </div>
        </div>
    </div>
</footer>
