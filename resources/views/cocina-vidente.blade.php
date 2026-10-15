@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Cocina);
@endphp

<x-layouts.app :title="$cms->text('title', 'cocina.title').' — '.config('app.name')">
    <div class="flex flex-1 flex-col bg-black-500 px-6 py-16 text-white lg:px-10 lg:py-24">
        {{-- Hero --}}
        <section class="mx-auto grid w-full max-w-[100rem] grid-cols-1 items-center gap-10 lg:grid-cols-2 lg:gap-16 xl:gap-24">
            <div class="mx-auto flex w-full max-w-md flex-col items-center justify-center text-center lg:py-8">
                <h1 class="sr-only">{{ $cms->text('title', 'cocina.title') }}</h1>

                <img
                    src="{{ $cms->asset('logo', 'images/home/Cocina Vidente.svg') }}"
                    alt="{{ $cms->text('title', 'cocina.title') }}"
                    width="297"
                    class="h-auto w-[200px] sm:w-[240px] lg:w-[297px]"
                >

                <p class="type-b2 mt-8 text-white">
                    {{ $cms->text('lead', 'cocina.lead') }}
                </p>

                <div class="mt-10 flex w-full flex-col gap-4">
                    <x-home.outline-button
                        :href="route('cigno-ermita.restaurant')"
                        variant="white-solid"
                        class="w-full"
                    >
                        {{ $cms->text('book_ermita', 'cocina.book_ermita') }}
                    </x-home.outline-button>

                    <x-home.outline-button
                        :href="route('cigno-mejorada.restaurant')"
                        variant="white-solid"
                        class="w-full"
                    >
                        {{ $cms->text('book_mejorada', 'cocina.book_mejorada') }}
                    </x-home.outline-button>

                    <x-home.outline-button
                        :href="$cms->text('menu_url', 'cocina.menu_url')"
                        variant="white"
                        class="w-full"
                    >
                        {{ $cms->text('see_menu', 'cocina.see_menu') }}
                    </x-home.outline-button>
                </div>
            </div>

            @php
                $cocinaHeroPoster = $cms->asset('hero_image', 'images/cocina/766674731_1038934385408593_3915687115600101391_n.jpg');
            @endphp
            <div class="relative aspect-[900/800] w-full overflow-hidden">
                <x-site-video
                    class="absolute inset-0 size-full object-cover"
                    preload="none"
                    data-managed
                    src="{{ $cms->asset('hero_video', 'videos/restaurante.mp4') }}"
                    poster="{{ $cocinaHeroPoster }}"
                    :aria-label="$cms->text('hero_image_alt', 'cocina.hero_image_alt')"
                />
            </div>
        </section>

        {{-- Chef --}}
        <section class="mx-auto mt-16 grid w-full max-w-[100rem] grid-cols-1 items-center gap-10 lg:mt-24 lg:grid-cols-2 lg:gap-16 xl:gap-24">
            <img
                src="{{ $cms->asset('chef.image', 'images/ermita/restaurant/Rectangle 4 (6).png') }}"
                alt="{{ $cms->text('chef.image_alt', 'cocina.chef.image_alt') }}"
                class="order-2 aspect-[900/800] w-full object-cover lg:order-1"
            >

            <div class="order-1 flex flex-col justify-center lg:order-2 lg:py-8 lg:pl-6">
                <img
                    src="{{ $cms->asset('chef.icon', 'images/cocina/isotipo.png') }}"
                    alt=""
                    width="72"
                    class="h-auto w-12 sm:w-14 lg:w-[72px]"
                >

                <h2 class="type-h1 mt-8 max-w-xl text-balance text-white">
                    {{ $cms->text('chef.title', 'cocina.chef.title') }}
                </h2>

                <div class="type-b2 mt-8 max-w-xl space-y-6 text-white">
                    <p>{{ $cms->text('chef.body_1', 'cocina.chef.body_1') }}</p>
                    <p>{{ $cms->text('chef.body_2', 'cocina.chef.body_2') }}</p>
                </div>
            </div>
        </section>
    </div>
</x-layouts.app>
