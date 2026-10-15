@php
    use App\Enums\CmsPageSlug;
    $cms = cms(CmsPageSlug::MejoradaRooms);
    $rooms = $cms->mejoradaRooms();
@endphp

<x-layouts.app :title="$cms->text('rooms_page.title', 'mejorada.rooms_page.title').' — '.__('nav.mejorada')">
    <section class="flex flex-1 flex-col bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto w-full max-w-6xl">
            <div class="mx-auto flex max-w-3xl flex-col items-center text-center">
                <img
                    src="{{ asset('images/ermita/icons/cisneentero.svg') }}"
                    alt=""
                    width="120"
                    class="h-auto w-[96px] sm:w-[120px]"
                >

                <h1 class="type-h1 mt-10">{{ $cms->text('rooms_page.title', 'mejorada.rooms_page.title') }}</h1>

                <div class="type-b2 mt-8 max-w-xl space-y-1">
                    <p>{{ $cms->text('rooms_page.lead_1', 'mejorada.rooms_page.lead_1') }}</p>
                    <p>{{ $cms->text('rooms_page.lead_2', 'mejorada.rooms_page.lead_2') }}</p>
                </div>
            </div>

            <div class="mt-16 grid grid-cols-1 items-stretch gap-x-8 gap-y-16 md:grid-cols-2 lg:mt-20 lg:gap-x-12 lg:gap-y-20">
                @foreach ($rooms as $room)
                    <x-mejorada.room-card
                        :image="$room['image']"
                        :title="$room['title']"
                        :body="$room['body']"
                        :people="$room['people']"
                        :beds="$room['beds']"
                        :info-href="route('cigno-mejorada.rooms.show', $room['slug'])"
                        :reserve-href="route('cigno-mejorada').'#booking'"
                    />
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
