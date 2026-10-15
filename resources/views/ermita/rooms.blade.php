@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::ErmitaRooms);
    $rooms = $cms->ermitaRooms();
@endphp

<x-layouts.app :title="$cms->text('rooms_page.title', 'ermita.rooms_page.title').' — '.__('nav.ermita')">
    <section class="flex flex-1 flex-col bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto w-full max-w-6xl">
            <div class="mx-auto flex max-w-3xl flex-col items-center text-center">
                <img
                    src="{{ asset('images/ermita/icons/cisneentero.svg') }}"
                    alt=""
                    width="274"
                    class="h-auto w-[220px] sm:w-[260px]"
                >

                <h1 class="type-h1 mt-10">{{ $cms->text('rooms_page.title', 'ermita.rooms_page.title') }}</h1>

                <div class="type-b2 mt-8 max-w-xl space-y-1">
                    <p>{{ $cms->text('rooms_page.lead_1', 'ermita.rooms_page.lead_1') }}</p>
                    <p>{{ $cms->text('rooms_page.lead_2', 'ermita.rooms_page.lead_2') }}</p>
                </div>
            </div>

            <div class="mt-16 grid grid-cols-1 items-stretch gap-x-8 gap-y-16 md:grid-cols-2 lg:mt-20 lg:gap-x-12 lg:gap-y-20">
                @foreach ($rooms as $room)
                    <x-ermita.room-card
                        :image="$room['image']"
                        :title="$room['title']"
                        :body="$room['body']"
                        :people="$room['people']"
                        :beds="$room['beds']"
                        :info-href="route('cigno-ermita.rooms.show', $room['slug'])"
                    />
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
