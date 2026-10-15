@php
    $brands = collect(config('navigation.brands'));
    $activeBrand = $brands->first(
        fn (array $brand): bool => filled($brand['match'] ?? null) && request()->routeIs($brand['match'])
    ) ?? $brands->firstWhere('key', 'main');

    $activeKey = $activeBrand['key'] ?? 'main';
    $menuKey = $activeBrand['menu'] ?? 'main';
    $isHotelMenu = in_array($menuKey, ['ermita', 'mejorada'], true);
    $branchItems = $isHotelMenu ? config('navigation.'.$menuKey, []) : [];
    $bookLabel = __($activeBrand['book_label'] ?? 'nav.book_in_cigno');
    $bookHotel = $activeBrand['book_hotel'] ?? null;
    $bookHref = $bookHotel
        ? route('booking.search', ['hotel' => $bookHotel])
        : route('home').'#booking';
    $bookClass = match ($activeKey) {
        'ermita' => 'border-blue-ermita-300 bg-blue-ermita-300 hover:border-blue-ermita-500 hover:bg-blue-ermita-500',
        'mejorada' => 'border-blue-mejorada-300 bg-blue-mejorada-300 hover:border-blue-mejorada-500 hover:bg-blue-mejorada-500',
        default => 'border-yellow-gold-300 bg-yellow-gold-300 hover:border-yellow-gold-500 hover:bg-yellow-gold-500',
    };

    $menuBrands = $brands->map(function (array $brand): array {
        $items = collect(config('navigation.'.$brand['menu'], []))
            ->map(fn (array $item): array => [
                'label' => __($item['label']),
                'href' => route($item['route']),
                'route' => $item['route'],
                'current' => request()->routeIs($item['route'])
                    || request()->routeIs($item['route'].'.*'),
            ])
            ->values()
            ->all();

        $bookHotel = $brand['book_hotel'] ?? null;

        return [
            'key' => $brand['key'],
            'label' => __($brand['label']),
            'route' => route($brand['route']),
            'explore' => __($brand['explore']),
            'items' => $items,
            'exploreItems' => collect($items)
                ->reject(fn (array $item): bool => ($item['route'] ?? null) === 'home')
                ->values()
                ->all(),
            'panel' => $brand['panel'],
            'image' => filled($brand['image'] ?? null) ? asset($brand['image']) : null,
            'video' => config('media.videos_enabled') && filled($brand['video'] ?? null)
                ? asset($brand['video'])
                : null,
            'caption' => filled($brand['image_caption'] ?? null) ? __($brand['image_caption']) : null,
            'showMichelin' => (bool) ($brand['show_michelin'] ?? false),
            'bookLabel' => __($brand['book_label'] ?? 'nav.book_in_cigno'),
            'bookHref' => $bookHotel
                ? route('booking.search', ['hotel' => $bookHotel])
                : route('home').'#booking',
        ];
    })->values()->all();

    $exploreHotelesLabel = __('nav.explore_hoteles');
@endphp

<div
    x-data="{
        menuOpen: false,
        langOpen: false,
        menuBrand: {{ \Illuminate\Support\Js::from($activeKey) }},
        brands: {{ \Illuminate\Support\Js::from($menuBrands) }},
        get active() {
            return this.brands.find((brand) => brand.key === this.menuBrand) || this.brands[0];
        },
        openMenu() {
            this.menuBrand = {{ \Illuminate\Support\Js::from($activeKey) }};
            this.menuOpen = true;
            this.langOpen = false;
        },
        closeMenu() {
            this.menuOpen = false;
        },
    }"
    @keydown.escape.window="langOpen ? langOpen = false : menuOpen = false"
    x-effect="document.body.classList.toggle('overflow-hidden', menuOpen)"
    @class(['has-branch-row' => $isHotelMenu])
>
    <header
        class="fixed inset-x-0 top-0 z-50"
        @click.outside="langOpen = false"
    >
        <div class="relative z-20 flex h-(--header-bar-height) items-center justify-between bg-off-white-300 px-5 sm:px-8 lg:px-12">
            {{-- Mobile: wordmark left. Desktop: menu + language left. --}}
            <div class="flex items-center gap-3 sm:gap-4">
                <a
                    href="{{ route('home') }}"
                    class="transition-opacity duration-300 hover:opacity-50 lg:hidden"
                >
                    <img
                        src="{{ asset('images/Logotipo (3).svg') }}"
                        alt="{{ config('app.name') }}"
                        width="128"
                        class="h-auto w-[110px] sm:w-[128px]"
                    >
                </a>

                <button
                    type="button"
                    class="hidden size-[48px] items-center justify-center transition-opacity duration-300 hover:opacity-40 lg:flex"
                    @click="menuOpen ? closeMenu() : openMenu()"
                    :aria-expanded="menuOpen"
                    aria-controls="site-menu"
                    :aria-label="menuOpen ? {{ \Illuminate\Support\Js::from(__('ui.close_menu')) }} : {{ \Illuminate\Support\Js::from(__('ui.open_menu')) }}"
                >
                    <img
                        src="{{ asset('images/menu-icon.svg') }}"
                        alt=""
                        width="48"
                        height="48"
                        class="size-[48px]"
                        x-show="! menuOpen"
                        x-cloak
                    >
                    <img
                        src="{{ asset('images/cierre.svg') }}"
                        alt=""
                        width="48"
                        height="48"
                        class="size-[48px]"
                        x-show="menuOpen"
                        x-cloak
                    >
                </button>

                <button
                    type="button"
                    class="hidden size-[48px] items-center justify-center transition-opacity duration-300 hover:opacity-40 lg:flex"
                    @click="langOpen = ! langOpen"
                    :aria-expanded="langOpen"
                    aria-controls="language-menu"
                    aria-haspopup="listbox"
                    :aria-label="langOpen ? {{ \Illuminate\Support\Js::from(__('ui.close_languages')) }} : {{ \Illuminate\Support\Js::from(__('ui.select_language')) }}"
                >
                    <img
                        src="{{ asset('images/Language.svg') }}"
                        alt=""
                        width="48"
                        height="48"
                        class="size-[48px]"
                    >
                </button>
            </div>

            {{-- Desktop centered wordmark --}}
            <a
                href="{{ route('home') }}"
                class="absolute left-1/2 hidden -translate-x-1/2 transition-opacity duration-300 hover:opacity-50 lg:block"
            >
                <img
                    src="{{ asset('images/Logotipo (3).svg') }}"
                    alt="{{ config('app.name') }}"
                    width="210"
                    class="h-auto w-[210px]"
                >
            </a>

            {{-- Mobile: language + menu. Desktop: book CTA. --}}
            <div class="flex items-center gap-1 sm:gap-2">
                <button
                    type="button"
                    class="flex size-[48px] items-center justify-center transition-opacity duration-300 hover:opacity-40 lg:hidden"
                    @click="langOpen = ! langOpen"
                    :aria-expanded="langOpen"
                    aria-controls="language-menu"
                    aria-haspopup="listbox"
                    :aria-label="langOpen ? {{ \Illuminate\Support\Js::from(__('ui.close_languages')) }} : {{ \Illuminate\Support\Js::from(__('ui.select_language')) }}"
                >
                    <img
                        src="{{ asset('images/Language.svg') }}"
                        alt=""
                        width="48"
                        height="48"
                        class="size-[48px]"
                    >
                </button>

                <button
                    type="button"
                    class="flex size-[48px] items-center justify-center transition-opacity duration-300 hover:opacity-40 lg:hidden"
                    @click="menuOpen ? closeMenu() : openMenu()"
                    :aria-expanded="menuOpen"
                    aria-controls="site-menu"
                    :aria-label="menuOpen ? {{ \Illuminate\Support\Js::from(__('ui.close_menu')) }} : {{ \Illuminate\Support\Js::from(__('ui.open_menu')) }}"
                >
                    <img
                        src="{{ asset('images/menu-icon.svg') }}"
                        alt=""
                        width="48"
                        height="48"
                        class="size-[48px]"
                        x-show="! menuOpen"
                        x-cloak
                    >
                    <img
                        src="{{ asset('images/cierre.svg') }}"
                        alt=""
                        width="48"
                        height="48"
                        class="size-[48px]"
                        x-show="menuOpen"
                        x-cloak
                    >
                </button>

                <a
                    href="{{ $bookHref }}"
                    class="type-btn-sm no-underline hidden items-center justify-center rounded-[14px] border px-5 py-2.5 text-white uppercase tracking-[0.08em] transition-colors duration-300 lg:inline-flex {{ $bookClass }}"
                >
                    {{ $bookLabel }}
                </a>
            </div>
        </div>

        @if ($isHotelMenu)
            <div
                class="relative z-10 flex h-(--branch-row-height) items-center justify-center border-t border-beige-300/80 bg-off-white-100 px-5 sm:px-8 lg:px-12"
            >
                <div class="flex h-full max-w-full items-center justify-center gap-8 overflow-x-auto lg:gap-10 xl:gap-12">
                    <p class="type-label flex h-full shrink-0 items-center leading-none text-black-500">
                        {{ __($activeBrand['short_label']) }}
                    </p>

                    <nav
                        class="hidden h-full items-center gap-5 lg:flex xl:gap-7"
                        aria-label="{{ __($activeBrand['label']) }}"
                    >
                        @foreach ($branchItems as $item)
                            @php
                                $isItemActive = request()->routeIs($item['route'])
                                    || request()->routeIs($item['route'].'.*');
                            @endphp
                            <a
                                href="{{ route($item['route']) }}"
                                @class([
                                    'type-b2 whitespace-nowrap transition-opacity duration-300',
                                    'text-black-500' => $isItemActive,
                                    'text-black-500/75 hover:text-black-500' => ! $isItemActive,
                                ])
                                @if ($isItemActive)
                                    aria-current="page"
                                @endif
                            >
                                {{ __($item['label']) }}
                            </a>
                        @endforeach
                    </nav>
                </div>
            </div>
        @endif

        <div
            id="language-menu"
            x-show="langOpen"
            x-cloak
            x-transition.opacity.duration.200ms
            role="listbox"
            aria-label="{{ __('ui.language') }}"
            class="absolute top-[calc(var(--header-bar-height)+0.5rem)] right-5 z-50 overflow-hidden text-left sm:right-8 lg:right-auto lg:left-20"
        >
            <ul class="flex flex-col">
                @foreach (config('languages.available') as $locale => $label)
                    <li>
                        <a
                            href="{{ route('locale.update', $locale) }}"
                            role="option"
                            aria-selected="{{ app()->getLocale() === $locale ? 'true' : 'false' }}"
                            lang="{{ $locale }}"
                            @class([
                                'type-s2 block px-[30px] py-[10px] text-center uppercase transition-colors duration-300',
                                'bg-yellow-gold-500 text-white' => app()->getLocale() === $locale,
                                'bg-off-white-100 text-black-500 hover:bg-beige-100' => app()->getLocale() !== $locale,
                            ])
                        >{{ $label }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </header>

    <div class="h-(--header-height)" aria-hidden="true"></div>

    <div
        id="site-menu"
        x-show="menuOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-250"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        role="dialog"
        aria-modal="true"
        aria-label="{{ __('ui.menu') }}"
        @class([
            'fixed inset-x-0 bottom-0 z-40 overflow-y-auto lg:overflow-hidden',
            'top-(--header-height)' => $isHotelMenu,
            'top-(--header-bar-height)' => ! $isHotelMenu,
        ])
        :class="{
            'bg-off-white-100 text-black-500': active.panel === 'light',
            'bg-blue-ermita-300 text-white': active.panel === 'ermita',
            'bg-blue-mejorada-300 text-white': active.panel === 'mejorada',
        }"
    >
        {{-- Mobile layout --}}
        <div class="mx-auto flex min-h-full w-full max-w-lg flex-col px-6 py-8 sm:px-10 lg:hidden">
            <template x-if="menuBrand === 'main'">
                <div class="flex flex-1 flex-col">
                    <nav aria-label="{{ __('ui.brand_nav') }}">
                        <ul class="flex flex-col gap-5">
                            <template x-for="brand in brands" :key="'m-brand-' + brand.key">
                                <li>
                                    <button
                                        type="button"
                                        class="type-s2 flex w-full items-center justify-between gap-4 text-left"
                                        @click="brand.key === 'main' ? (window.location.href = brand.route) : (menuBrand = brand.key)"
                                    >
                                        <span x-text="brand.label"></span>
                                        <span class="text-xl leading-none opacity-70" aria-hidden="true">›</span>
                                    </button>
                                </li>
                            </template>
                        </ul>
                    </nav>

                    <div class="mt-8 border-t border-black-500/25 pt-8">
                        <p class="type-b3 mb-5" x-text="active.explore"></p>

                        <nav aria-label="{{ __('ui.main_nav') }}">
                            <ul class="flex flex-col gap-4">
                                <template x-for="item in active.exploreItems" :key="'m-explore-' + item.href">
                                    <li>
                                        <a
                                            :href="item.href"
                                            class="type-s2 transition-opacity duration-300 hover:opacity-55"
                                            :aria-current="item.current ? 'page' : null"
                                            @click="closeMenu()"
                                            x-text="item.label"
                                        ></a>
                                    </li>
                                </template>
                            </ul>
                        </nav>
                    </div>

                    <div class="mt-8 border-t border-black-500/25 pt-8">
                        <a
                            :href="active.bookHref"
                            class="type-btn-sm no-underline inline-flex w-full items-center justify-center rounded-[14px] border border-yellow-gold-300 bg-yellow-gold-300 px-5 py-3.5 text-center text-white uppercase tracking-[0.08em] transition-colors duration-300 hover:border-yellow-gold-500 hover:bg-yellow-gold-500"
                            @click="closeMenu()"
                            x-text="active.bookLabel"
                        ></a>
                    </div>

                    <div class="mt-auto flex items-center gap-5 pt-10">
                        <a
                            href="{{ route('contact') }}"
                            class="transition-opacity duration-300 hover:opacity-50"
                            aria-label="{{ __('ui.call') }}"
                            @click="closeMenu()"
                        >
                            <img src="{{ asset('images/footer/llamada.svg') }}" alt="" class="size-7">
                        </a>
                        <a
                            href="#"
                            class="transition-opacity duration-300 hover:opacity-50"
                            aria-label="{{ __('ui.instagram') }}"
                            rel="noopener noreferrer"
                        >
                            <img src="{{ asset('images/footer/ig.svg') }}" alt="" class="size-7">
                        </a>
                    </div>
                </div>
            </template>

            <template x-if="menuBrand !== 'main'">
                <div class="flex flex-1 flex-col">
                    <p class="type-b3 mb-6" x-text="active.explore"></p>

                    <nav aria-label="{{ __('ui.main_nav') }}">
                        <ul class="flex flex-col gap-4">
                            <template x-for="item in active.items" :key="'m-hotel-' + item.href">
                                <li>
                                    <a
                                        :href="item.href"
                                        class="type-s2 transition-opacity duration-300 hover:opacity-55"
                                        :aria-current="item.current ? 'page' : null"
                                        @click="closeMenu()"
                                        x-text="item.label"
                                    ></a>
                                </li>
                            </template>
                        </ul>
                    </nav>

                    <div class="mt-10 border-t border-white/35 pt-8">
                        <button
                            type="button"
                            class="type-b3 text-left transition-opacity duration-300 hover:opacity-70"
                            @click="menuBrand = 'main'"
                        >
                            {{ $exploreHotelesLabel }}
                        </button>

                        <a
                            :href="active.bookHref"
                            class="type-btn-sm no-underline mt-8 inline-flex w-full items-center justify-center rounded-[14px] border border-off-white-100 bg-off-white-100 px-5 py-3.5 text-center uppercase tracking-[0.08em] transition-opacity duration-300 hover:opacity-90"
                            :class="active.panel === 'ermita' ? 'text-blue-ermita-300' : 'text-blue-mejorada-300'"
                            @click="closeMenu()"
                            x-text="active.bookLabel"
                        ></a>
                    </div>

                    <div class="mt-auto flex items-center gap-5 pt-10">
                        <a
                            href="{{ route('contact') }}"
                            class="transition-opacity duration-300 hover:opacity-50"
                            aria-label="{{ __('ui.call') }}"
                            @click="closeMenu()"
                        >
                            <img
                                src="{{ asset('images/footer/llamada.svg') }}"
                                alt=""
                                class="size-7 brightness-0 invert"
                            >
                        </a>
                        <a
                            href="#"
                            class="transition-opacity duration-300 hover:opacity-50"
                            aria-label="{{ __('ui.instagram') }}"
                            rel="noopener noreferrer"
                        >
                            <img
                                src="{{ asset('images/footer/ig.svg') }}"
                                alt=""
                                class="size-7 brightness-0 invert"
                            >
                        </a>
                        <template x-if="active.showMichelin">
                            <img
                                src="{{ asset('images/ermita/michelin.svg') }}"
                                alt="{{ __('nav.michelin_2025') }}"
                                height="20"
                                class="h-5 w-auto brightness-0 invert"
                            >
                        </template>
                    </div>
                </div>
            </template>
        </div>

        {{-- Desktop layout --}}
        <div class="relative mx-auto hidden h-full w-full max-w-[105rem] grid-cols-3 lg:grid">
            <div
                class="site-menu-divider pointer-events-none absolute top-[10%] bottom-[10%] left-1/3 z-20 -translate-x-1/2"
                :class="active.panel === 'light' ? 'is-light' : 'is-dark'"
                aria-hidden="true"
            ></div>
            <div
                class="site-menu-divider pointer-events-none absolute top-[10%] bottom-[10%] left-2/3 z-20 -translate-x-1/2"
                :class="active.panel === 'light' ? 'is-light' : 'is-dark'"
                aria-hidden="true"
            ></div>

            <div class="relative flex min-h-0 flex-col px-10 py-10 xl:px-12 xl:py-14">
                <nav
                    class="flex min-h-0 flex-1 flex-col justify-center"
                    aria-label="{{ __('ui.brand_nav') }}"
                >
                    <ul class="flex flex-col gap-8 xl:gap-[60px]">
                        <template x-for="brand in brands" :key="'d-brand-' + brand.key">
                            <li>
                                <button
                                    type="button"
                                    class="type-h3 text-left transition-opacity duration-300 hover:opacity-70"
                                    :class="menuBrand === brand.key ? 'underline underline-offset-[10px] decoration-1' : 'opacity-80'"
                                    @click="menuBrand = brand.key"
                                    @mouseenter="menuBrand = brand.key"
                                    :aria-current="menuBrand === brand.key ? 'true' : 'false'"
                                    x-text="brand.label"
                                ></button>
                            </li>
                        </template>
                    </ul>
                </nav>

                <div class="flex shrink-0 items-center gap-5 pt-8 xl:pt-10">
                    <a
                        href="{{ route('contact') }}"
                        class="transition-opacity duration-300 hover:opacity-50"
                        aria-label="{{ __('ui.call') }}"
                        @click="closeMenu()"
                    >
                        <img
                            src="{{ asset('images/footer/llamada.svg') }}"
                            alt=""
                            class="size-7"
                            :class="active.panel === 'light' ? '' : 'brightness-0 invert'"
                        >
                    </a>
                    <a
                        href="#"
                        class="transition-opacity duration-300 hover:opacity-50"
                        aria-label="{{ __('ui.instagram') }}"
                        rel="noopener noreferrer"
                    >
                        <img
                            src="{{ asset('images/footer/ig.svg') }}"
                            alt=""
                            class="size-7"
                            :class="active.panel === 'light' ? '' : 'brightness-0 invert'"
                        >
                    </a>
                    <template x-if="active.showMichelin">
                        <img
                            src="{{ asset('images/ermita/michelin.svg') }}"
                            alt="{{ __('nav.michelin_2025') }}"
                            height="20"
                            class="h-5 w-auto"
                            :class="active.panel === 'light' ? '' : 'brightness-0 invert'"
                        >
                    </template>
                </div>
            </div>

            <div class="relative flex min-h-0 flex-col justify-center px-10 py-10 xl:px-12 xl:py-14">
                <p
                    class="type-b3 mb-6 shrink-0 opacity-90 xl:mb-10"
                    x-text="active.explore"
                ></p>

                <nav class="min-h-0" aria-label="{{ __('ui.main_nav') }}">
                    <ul class="flex flex-col gap-2 xl:gap-3">
                        <template x-for="item in active.items" :key="'d-item-' + item.href">
                            <li>
                                <a
                                    :href="item.href"
                                    class="type-s2 transition-opacity duration-300 hover:opacity-55"
                                    :aria-current="item.current ? 'page' : null"
                                    @click="closeMenu()"
                                    x-text="item.label"
                                ></a>
                            </li>
                        </template>
                    </ul>
                </nav>
            </div>

            <div class="site-menu-media-frame flex min-h-0 items-center justify-center overflow-hidden px-10 py-10 xl:px-12 xl:py-14">
                <template x-if="active.video">
                    <figure class="site-menu-media relative overflow-hidden" :key="'menu-video-' + active.key">
                        <video
                            class="size-full object-cover"
                            muted
                            loop
                            playsinline
                            preload="metadata"
                            :poster="active.image || undefined"
                            aria-hidden="true"
                            data-managed
                            x-init="$nextTick(() => { $el.play?.().catch(() => {}) })"
                        >
                            <source :src="active.video" type="video/mp4">
                        </video>
                        <figcaption
                            x-show="active.caption"
                            class="pointer-events-none absolute inset-0 flex items-center justify-center px-6 text-center"
                        >
                            <span
                                class="font-serif text-xl italic text-white drop-shadow-md sm:text-2xl"
                                x-text="active.caption"
                            ></span>
                        </figcaption>
                    </figure>
                </template>
                <template x-if="! active.video && active.image">
                    <figure class="site-menu-media relative overflow-hidden" :key="'menu-image-' + active.key">
                        <img
                            :src="active.image"
                            alt=""
                            class="size-full object-cover"
                        >
                        <figcaption
                            x-show="active.caption"
                            class="pointer-events-none absolute inset-0 flex items-center justify-center px-6 text-center"
                        >
                            <span
                                class="font-serif text-xl italic text-white drop-shadow-md sm:text-2xl"
                                x-text="active.caption"
                            ></span>
                        </figcaption>
                    </figure>
                </template>
            </div>
        </div>
    </div>
</div>
