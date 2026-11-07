@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Home);
@endphp

<section class="site-section bg-beige-500 text-black-500">
    <div class="site-shell grid grid-cols-1 items-center gap-[var(--site-gap)] lg:grid-cols-2 lg:gap-[clamp(2.5rem,5vw,5rem)]">
        <div class="min-w-0 lg:pr-[clamp(0rem,2vw,2rem)]">
            <img
                src="{{ $cms->asset('destination.icon', 'images/home/Vector (15).svg') }}"
                alt=""
                width="56"
                height="56"
                class="h-14 w-auto"
            >

            <h2 class="type-h2 mt-8">
                {{ $cms->text('destination.title', 'home.destination.title') }}
            </h2>

            <div class="type-b2 mt-6 max-w-[36rem] space-y-4">
                <p>{{ $cms->text('destination.lead_1', 'home.destination.lead_1') }}</p>
                <p>{{ $cms->text('destination.lead_2', 'home.destination.lead_2') }}</p>
            </div>
        </div>

        <div class="relative aspect-[650/600] min-w-0 overflow-hidden">
            <img
                src="{{ $cms->asset('destination.image', 'images/home/destinos.png') }}"
                alt=""
                class="absolute inset-0 size-full object-cover"
            >
        </div>
    </div>
</section>
