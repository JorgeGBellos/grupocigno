@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Home);
@endphp

<section class="bg-beige-500 px-6 py-20 text-black-500 lg:px-10 lg:py-28">
    <div class="mx-auto grid max-w-6xl grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-16 xl:gap-20">
        <div>
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

            <div class="type-b2 mt-6 max-w-xl space-y-4">
                <p>{{ $cms->text('destination.lead_1', 'home.destination.lead_1') }}</p>
                <p>{{ $cms->text('destination.lead_2', 'home.destination.lead_2') }}</p>
            </div>
        </div>

        @php
            $destinationPoster = $cms->asset('destination.image', 'images/home/destinos.png');
        @endphp
        <div class="relative aspect-[650/600] overflow-hidden">
            <x-site-video
                class="absolute inset-0 size-full object-cover"
                preload="none"
                aria-hidden="true"
                data-managed
                src="{{ $cms->asset('destination.video', 'videos/Copia de Reel 02 Barrio de La Mejorada.mp4') }}"
                poster="{{ $destinationPoster }}"
            />
        </div>
    </div>
</section>
