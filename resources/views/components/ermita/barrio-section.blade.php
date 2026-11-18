@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Ermita);
@endphp

<section class="bg-beige-500 site-section text-black-500" aria-labelledby="ermita-barrio-title">
    <div class="site-shell grid grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-16 xl:gap-24">
        <img
            src="{{ $cms->asset('barrio.image', 'images/ermita/home/barrio.png') }}"
            alt="{{ __('ermita.barrio.image_alt') }}"
            class="aspect-square w-full object-cover"
        >

        <div class="flex max-w-xl flex-col">
            <img
                src="{{ asset('images/ermita/icons/Vector (16).svg') }}"
                alt=""
                width="72"
                class="h-auto w-14 lg:w-[72px]"
            >

            <h2 id="ermita-barrio-title" class="type-h1 mt-8">
                {{ $cms->text('barrio.title', 'ermita.barrio.title') }}
            </h2>

            <div class="type-b2 mt-6 space-y-4">
                <p>{{ $cms->text('barrio.lead_1', 'ermita.barrio.lead_1') }}</p>
                <p>{{ $cms->text('barrio.lead_2', 'ermita.barrio.lead_2') }}</p>
            </div>

            <x-ermita.button :href="route('cigno-ermita.barrio')" class="mt-10 w-full max-w-md">
                {{ $cms->text('barrio.cta', 'ermita.barrio.cta') }}
            </x-ermita.button>
        </div>
    </div>
</section>
