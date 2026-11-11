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
    {{-- Partner logos --}}
    <div class="border-y border-black-500">
        <div class="site-shell flex flex-wrap items-center justify-center gap-x-8 gap-y-5 px-[var(--site-gutter)] py-6 sm:gap-x-10 lg:gap-[50px] xl:py-8">
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

    {{-- Black Swan + legales + social --}}
    <div>
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

            <div class="flex items-center justify-center gap-5 lg:justify-self-end">
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
