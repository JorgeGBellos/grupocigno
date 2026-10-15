@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Home);
@endphp

<section class="grid min-h-[min(100svh,56rem)] grid-cols-1 lg:min-h-[48rem] lg:grid-cols-2" aria-label="{{ __('nav.shop') }} / {{ __('nav.press') }}">
    <a
        href="{{ route('shop') }}"
        class="group relative flex min-h-[28rem] flex-col items-center justify-center overflow-hidden px-8 py-20 text-center text-white lg:min-h-0 lg:px-14 lg:py-24"
    >
        <img
            src="{{ $cms->asset('tiendita.background', 'images/home/Cigno Club.png') }}"
            alt=""
            class="absolute inset-0 size-full object-cover transition-transform duration-700 group-hover:scale-[1.03]"
        >

        <div class="relative z-10 flex max-w-lg flex-col items-center">
            <h1 class="type-h1 text-white">Tiendita</h1>

            <p class="type-b1 mt-8 text-white">
                {{ $cms->text('tiendita.body', 'home.tiendita.body') }}
            </p>

            <span class="type-btn-md mt-12 inline-flex w-full max-w-sm items-center justify-center rounded-[14px] border border-white px-12 py-3.5 uppercase tracking-[0.08em] text-white no-underline transition-colors duration-300 group-hover:bg-white group-hover:text-yellow-gold-500">
                {{ $cms->text('tiendita.cta', 'home.tiendita.cta') }}
            </span>
        </div>
    </a>

    <a
        href="{{ route('press') }}"
        class="group relative flex min-h-[28rem] flex-col items-center justify-center overflow-hidden px-8 py-20 text-center text-white lg:min-h-0 lg:px-14 lg:py-24"
    >
        <img
            src="{{ $cms->asset('press.background', 'images/home/Experience Collection.png') }}"
            alt=""
            class="absolute inset-0 size-full object-cover transition-transform duration-700 group-hover:scale-[1.03]"
        >

        <div class="relative z-10 flex max-w-lg flex-col items-center">
            <h1 class="type-h1 text-white">{{ __('nav.press') }}</h1>

            <p class="type-b1 mt-8 text-white">
                {{ $cms->text('press.body', 'home.press.body') }}
            </p>

            <span class="type-btn-md mt-12 inline-flex w-full max-w-sm items-center justify-center rounded-[14px] border border-white px-12 py-3.5 uppercase tracking-[0.08em] text-white no-underline transition-colors duration-300 group-hover:bg-white group-hover:text-yellow-gold-500">
                {{ $cms->text('press.cta', 'home.press.cta') }}
            </span>
        </div>
    </a>
</section>
