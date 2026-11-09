@php
    $brands = collect(config('navigation.brands'));
    $activeBrand = $brands->first(
        fn (array $brand): bool => filled($brand['match'] ?? null) && request()->routeIs($brand['match'])
    ) ?? $brands->firstWhere('key', 'main');

    $activeKey = $activeBrand['key'] ?? 'main';
    $menuKey = $activeBrand['menu'] ?? 'main';
    $isHotelMenu = in_array($menuKey, ['ermita', 'mejorada'], true);
    $showBranchRow = true;
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
            ->map(function (array $item): array {
                if (filled($item['url'] ?? null)) {
                    $href = url($item['url']);
                } else {
                    $href = route($item['route'], $item['params'] ?? []);
                    if (filled($item['hash'] ?? null)) {
                        $href .= '#'.$item['hash'];
                    }
                }

                return [
                    'label' => __($item['label']),
                    'href' => $href,
                    'route' => $item['route'] ?? null,
                    'current' => filled($item['route'] ?? null)
                        && blank($item['hash'] ?? null)
                        && blank($item['url'] ?? null)
                        && (request()->routeIs($item['route'])
                            || request()->routeIs($item['route'].'.*')),
                ];
            })
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
            'instagram' => config('social.instagram.'.$brand['key'])
                ?? config('social.instagram.main'),
            'phoneHref' => filled(config('social.phone.'.$brand['key']))
                ? 'tel:'.preg_replace('/\D+/', '', (string) config('social.phone.'.$brand['key']))
                : route('contact'),
        ];
    })->values()->all();

@endphp

<div
    x-data="{
        menuOpen: false,
        langOpen: false,
        menuBrand: null,
        menuCol2: false,
        branchVisible: true,
        lastScrollY: 0,
        brands: {{ \Illuminate\Support\Js::from($menuBrands) }},
        get active() {
            if (! this.menuBrand) {
                return this.brands.find((brand) => brand.key === 'main') || this.brands[0];
            }

            return this.brands.find((brand) => brand.key === this.menuBrand) || this.brands[0];
        },
        get branchShown() {
            return this.branchVisible || this.menuOpen;
        },
        init() {
            this.lastScrollY = window.scrollY || 0;
            this.onWindowScroll();
        },
        openMenu() {
            this.menuBrand = null;
            this.menuCol2 = false;
            this.menuOpen = true;
            this.langOpen = false;
        },
        closeMenu() {
            this.menuOpen = false;
            this.menuBrand = null;
            this.menuCol2 = false;
        },
        selectMenuBrand(key) {
            this.menuBrand = key;
            this.menuCol2 = true;
        },
        backToMainMenu() {
            this.menuBrand = null;
            this.menuCol2 = false;
        },
        onWindowScroll() {
            if (this.menuOpen) {
                this.branchVisible = true;
                this.lastScrollY = window.scrollY || window.pageYOffset || 0;

                return;
            }

            const y = window.scrollY || window.pageYOffset || 0;

            if (y <= 12) {
                this.branchVisible = true;
            } else if (y > this.lastScrollY + 4) {
                this.branchVisible = false;
            } else if (y < this.lastScrollY - 4) {
                this.branchVisible = true;
            }

            this.lastScrollY = y;
        },
    }"
    @keydown.escape.window="langOpen ? langOpen = false : menuOpen = false"
    @scroll.window="onWindowScroll()"
    x-effect="
        document.body.classList.toggle('overflow-hidden', menuOpen);
        document.body.classList.toggle('is-branch-collapsed', ! branchShown);
    "
    @class(['has-branch-row' => $showBranchRow])
    :class="{ 'is-branch-collapsed': ! branchShown }"
>
    <header
        class="fixed inset-x-0 top-0 z-50"
        @click.outside="langOpen = false"
    >
        <div class="relative z-20 flex h-(--header-bar-height) items-center justify-between bg-off-white-300 px-[var(--site-gutter)]">
            {{-- Mobile: wordmark left. Desktop: menu + language left. --}}
            <div class="flex items-center gap-2 sm:gap-4">
                <a
                    href="{{ route('home') }}"
                    class="transition-opacity duration-300 hover:opacity-50 lg:hidden"
                >
                    <img
                        src="{{ asset('images/Logotipo (3).svg') }}"
                        alt="{{ config('app.name') }}"
                        width="128"
                        class="h-auto w-[88px] sm:w-[110px]"
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
            <div class="flex items-center gap-0.5 sm:gap-2">
                <button
                    type="button"
                    class="flex size-10 items-center justify-center transition-opacity duration-300 hover:opacity-40 lg:hidden"
                    @click="langOpen = ! langOpen"
                    :aria-expanded="langOpen"
                    aria-controls="language-menu"
                    aria-haspopup="listbox"
                    :aria-label="langOpen ? {{ \Illuminate\Support\Js::from(__('ui.close_languages')) }} : {{ \Illuminate\Support\Js::from(__('ui.select_language')) }}"
                >
                    <img
                        src="{{ asset('images/Language.svg') }}"
                        alt=""
                        width="40"
                        height="40"
                        class="size-10"
                    >
                </button>

                <button
                    type="button"
                    class="flex size-10 items-center justify-center transition-opacity duration-300 hover:opacity-40 lg:hidden"
                    @click="menuOpen ? closeMenu() : openMenu()"
                    :aria-expanded="menuOpen"
                    aria-controls="site-menu"
                    :aria-label="menuOpen ? {{ \Illuminate\Support\Js::from(__('ui.close_menu')) }} : {{ \Illuminate\Support\Js::from(__('ui.open_menu')) }}"
                >
                    <img
                        src="{{ asset('images/menu-icon.svg') }}"
                        alt=""
                        width="40"
                        height="40"
                        class="size-10"
                        x-show="! menuOpen"
                        x-cloak
                    >
                    <img
                        src="{{ asset('images/cierre.svg') }}"
                        alt=""
                        width="40"
                        height="40"
                        class="size-10"
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

        @if ($showBranchRow)
            <div
                class="site-branch-row relative z-10 flex items-center justify-center border-t border-beige-300/80 bg-off-white-100 px-[var(--site-gutter)]"
                :aria-hidden="branchShown ? 'false' : 'true'"
            >
                @if ($isHotelMenu)
                    <div class="flex h-full max-w-full items-center justify-center gap-5 overflow-x-auto lg:gap-6 xl:gap-10 2xl:gap-12">
                        <p class="type-label flex h-full shrink-0 items-center leading-none text-black-500">
                            {{ __($activeBrand['short_label']) }}
                        </p>

                        <nav
                            class="hidden h-full items-center gap-3.5 lg:flex xl:gap-5 2xl:gap-7"
                            aria-label="{{ __($activeBrand['label']) }}"
                        >
                            @foreach ($branchItems as $item)
                                @php
                                    if (filled($item['url'] ?? null)) {
                                        $itemHref = url($item['url']);
                                    } else {
                                        $itemHref = route($item['route'], $item['params'] ?? []);
                                        if (filled($item['hash'] ?? null)) {
                                            $itemHref .= '#'.$item['hash'];
                                        }
                                    }
                                    $isItemActive = filled($item['route'] ?? null)
                                        && blank($item['hash'] ?? null)
                                        && blank($item['url'] ?? null)
                                        && (request()->routeIs($item['route'])
                                            || request()->routeIs($item['route'].'.*'));
                                @endphp
                                <a
                                    href="{{ $itemHref }}"
                                    @class([
                                        'font-serif whitespace-nowrap leading-snug transition-opacity duration-300 text-[0.8125rem] xl:text-[0.9375rem] 2xl:text-base',
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
                @else
                    <img
                        src="{{ asset('images/hoteles.svg') }}"
                        alt="Cigno Hoteles"
                        width="105"
                        height="30"
                        class="h-[30px] w-auto"
                    >
                @endif
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

    <div class="h-(--header-height) transition-[height] duration-300 ease-out" aria-hidden="true"></div>

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
            'top-(--header-height)' => $showBranchRow,
            'top-(--header-bar-height)' => ! $showBranchRow,
        ])
        :class="{
            'bg-off-white-100 text-black-500': active.panel === 'light',
            'bg-blue-ermita-300 text-white': active.panel === 'ermita',
            'bg-blue-mejorada-300 text-white': active.panel === 'mejorada',
        }"
    >
        {{-- Mobile layout --}}
        <div class="mx-auto flex min-h-full w-full max-w-lg flex-col px-6 py-8 sm:px-10 lg:hidden">
            {{-- Root: 3 brands --}}
            <template x-if="! menuBrand">
                <div class="flex flex-1 flex-col">
                    <nav aria-label="{{ __('ui.brand_nav') }}">
                        <ul class="flex flex-col gap-5">
                            <template x-for="brand in brands" :key="'m-brand-' + brand.key">
                                <li>
                                    <button
                                        type="button"
                                        class="type-s2 flex w-full items-center justify-between gap-4 text-left"
                                        @click="selectMenuBrand(brand.key)"
                                    >
                                        <span x-text="brand.label"></span>
                                        <span class="text-xl leading-none opacity-70" aria-hidden="true">›</span>
                                    </button>
                                </li>
                            </template>
                        </ul>
                    </nav>

                    <div class="mt-auto flex flex-col gap-8 pt-12">
                        <a
                            :href="active.bookHref"
                            class="type-btn-sm no-underline inline-flex w-full items-center justify-center rounded-[14px] border border-yellow-gold-300 bg-yellow-gold-300 px-5 py-3.5 text-center text-white uppercase tracking-[0.08em] transition-colors duration-300 hover:border-yellow-gold-500 hover:bg-yellow-gold-500"
                            @click="closeMenu()"
                            x-text="active.bookLabel"
                        ></a>

                        <div class="flex items-center gap-5">
                            <a
                                :href="active.phoneHref"
                                class="transition-opacity duration-300 hover:opacity-50"
                                aria-label="{{ __('ui.call') }}"
                                @click="closeMenu()"
                            >
                                <img src="{{ asset('images/footer/llamada.svg') }}" alt="" class="size-7">
                            </a>
                            <a
                                :href="active.instagram"
                                class="transition-opacity duration-300 hover:opacity-50"
                                aria-label="{{ __('ui.instagram') }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                @click="closeMenu()"
                            >
                                <img src="{{ asset('images/footer/ig.svg') }}" alt="" class="size-7">
                            </a>
                        </div>
                    </div>
                </div>
            </template>

            {{-- Subsection: Hoteles / Ermita / Mejorada --}}
            <template x-if="menuBrand">
                <div class="flex flex-1 flex-col">
                    <button
                        type="button"
                        class="type-s2 flex items-center gap-2 text-left transition-opacity duration-300 hover:opacity-70"
                        @click="backToMainMenu()"
                    >
                        <span aria-hidden="true">‹</span>
                        <span>{{ __('ui.back_to_main_menu') }}</span>
                    </button>

                    <div
                        class="mt-6 border-t"
                        :class="active.panel === 'light' ? 'border-black-500/25' : 'border-white/35'"
                    ></div>

                    <p
                        class="type-label mt-6 mb-5"
                        :class="active.panel === 'light' ? 'text-black-300' : 'text-white/70'"
                        x-text="active.explore"
                    ></p>

                    <nav aria-label="{{ __('ui.main_nav') }}">
                        <ul class="flex flex-col gap-4">
                            <template
                                x-for="item in (menuBrand === 'main' ? active.exploreItems : active.items)"
                                :key="'m-sub-' + item.href"
                            >
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

                    <div class="mt-auto flex flex-col gap-8 pt-12">
                        <a
                            :href="active.bookHref"
                            class="type-btn-sm no-underline inline-flex w-full items-center justify-center rounded-[14px] border px-5 py-3.5 text-center uppercase tracking-[0.08em] transition-colors duration-300"
                            :class="active.panel === 'light'
                                ? 'border-yellow-gold-300 bg-yellow-gold-300 text-white hover:border-yellow-gold-500 hover:bg-yellow-gold-500'
                                : (active.panel === 'ermita'
                                    ? 'border-off-white-100 bg-off-white-100 text-blue-ermita-300 hover:opacity-90'
                                    : 'border-off-white-100 bg-off-white-100 text-blue-mejorada-300 hover:opacity-90')"
                            @click="closeMenu()"
                            x-text="active.bookLabel"
                        ></a>

                        <div class="flex flex-col gap-6">
                            <div class="flex items-center gap-5">
                                <a
                                    :href="active.phoneHref"
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
                                    :href="active.instagram"
                                    class="transition-opacity duration-300 hover:opacity-50"
                                    aria-label="{{ __('ui.instagram') }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    @click="closeMenu()"
                                >
                                    <img
                                        src="{{ asset('images/footer/ig.svg') }}"
                                        alt=""
                                        class="size-7"
                                        :class="active.panel === 'light' ? '' : 'brightness-0 invert'"
                                    >
                                </a>
                            </div>
                            <template x-if="active.showMichelin">
                                <x-ermita.michelin-badges size="menu" class="justify-start" />
                            </template>
                        </div>
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

            <div class="relative flex min-h-0 flex-col px-10 pt-[clamp(3.5rem,14vh,8rem)] pb-10 xl:px-12 xl:pb-14">
                <nav
                    class="flex min-h-0 flex-1 flex-col justify-start"
                    aria-label="{{ __('ui.brand_nav') }}"
                >
                    <ul class="flex flex-col gap-5 xl:gap-8 2xl:gap-[60px]">
                        <template x-for="brand in brands" :key="'d-brand-' + brand.key">
                            <li>
                                <a
                                    :href="brand.route"
                                    class="site-menu-brand block text-left transition-opacity duration-300 hover:opacity-70"
                                    :class="menuCol2 && menuBrand === brand.key ? 'is-active' : 'opacity-80'"
                                    @mouseenter="selectMenuBrand(brand.key)"
                                    @focus="selectMenuBrand(brand.key)"
                                    @click="closeMenu()"
                                    :aria-current="menuCol2 && menuBrand === brand.key ? 'true' : 'false'"
                                    x-text="brand.label"
                                ></a>
                            </li>
                        </template>
                    </ul>
                </nav>

                <div class="flex shrink-0 flex-col gap-3 pt-6 xl:gap-5 xl:pt-10">
                    <div class="flex items-center gap-4 xl:gap-5">
                        <a
                            :href="active.phoneHref"
                            class="transition-opacity duration-300 hover:opacity-50"
                            aria-label="{{ __('ui.call') }}"
                            @click="closeMenu()"
                        >
                            <img
                                src="{{ asset('images/footer/llamada.svg') }}"
                                alt=""
                                class="size-6 xl:size-7"
                                :class="active.panel === 'light' ? '' : 'brightness-0 invert'"
                            >
                        </a>
                        <a
                            :href="active.instagram"
                            class="transition-opacity duration-300 hover:opacity-50"
                            aria-label="{{ __('ui.instagram') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            @click="closeMenu()"
                        >
                            <img
                                src="{{ asset('images/footer/ig.svg') }}"
                                alt=""
                                class="size-6 xl:size-7"
                                :class="active.panel === 'light' ? '' : 'brightness-0 invert'"
                            >
                        </a>
                    </div>
                    <template x-if="active.showMichelin">
                        <x-ermita.michelin-badges size="menu" class="justify-start" />
                    </template>
                </div>
            </div>

            <div class="relative flex min-h-0 flex-col justify-start px-10 pt-[clamp(3.5rem,14vh,8rem)] pb-10 xl:px-12 xl:pb-14">
                <div x-show="menuCol2" x-cloak>
                    <p
                        class="type-label mb-6 shrink-0 xl:mb-10"
                        :class="active.panel === 'light' ? 'text-black-300' : 'text-white/70'"
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
