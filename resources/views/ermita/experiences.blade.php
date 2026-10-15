@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::ErmitaExperiences);
    $items = __('ermita.experiences_page.items');
    $groups = [
        ['class' => 'sm:grid-cols-2 lg:grid-cols-3', 'aspect' => 'aspect-[3/4]', 'items' => array_slice($items, 0, 3)],
        ['class' => 'sm:grid-cols-2', 'aspect' => 'aspect-[5/4]', 'items' => array_slice($items, 3, 2)],
        ['class' => 'sm:grid-cols-2', 'aspect' => 'aspect-[5/4]', 'items' => array_slice($items, 5, 2)],
    ];
@endphp

<x-layouts.app :title="$cms->text('experiences_page.title', 'ermita.experiences_page.title').' — '.__('nav.ermita')">
    <section class="bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto flex w-full max-w-3xl flex-col items-center text-center">
            <img
                src="{{ asset('images/ermita/icons/cisneentero.svg') }}"
                alt=""
                width="274"
                class="h-auto w-[220px] sm:w-[260px]"
            >

            <h1 class="type-h1 mt-10 max-w-xl text-balance">{{ $cms->text('experiences_page.title', 'ermita.experiences_page.title') }}</h1>

            <p class="type-b2 mt-8">{{ $cms->text('experiences_page.lead', 'ermita.experiences_page.lead') }}</p>

            <p class="type-b2 mt-6 max-w-xl">{{ $cms->text('experiences_page.intro', 'ermita.experiences_page.intro') }}</p>

            <x-ermita.button :href="route('cigno-ermita').'#booking'" class="mt-10 w-full max-w-lg">
                {{ __('ermita.experiences_page.book') }}
            </x-ermita.button>
        </div>
    </section>

    @foreach ($groups as $group)
        <section class="bg-off-white-300 px-6 pb-16 text-black-500 lg:px-10 lg:pb-20">
            <div class="mx-auto grid max-w-6xl grid-cols-1 gap-12 {{ $group['class'] }} lg:gap-8">
                @foreach ($group['items'] as $item)
                    <article>
                        @if (! empty($item['video']))
                            <div class="relative {{ $group['aspect'] }} overflow-hidden">
                                <x-site-video
                                    class="absolute inset-0 size-full object-cover"
                                    preload="none"
                                    data-managed
                                    src="{{ asset('videos/'.preg_replace('/\.mov$/i', '.mp4', $item['video'])) }}"
                                    poster="{{ asset($item['image']) }}"
                                    :aria-label="$item['title']"
                                />
                            </div>
                        @else
                            <img
                                src="{{ asset($item['image']) }}"
                                alt="{{ $item['title'] }}"
                                class="{{ $group['aspect'] }} w-full object-cover"
                            >
                        @endif
                        <h2 class="type-s2 mt-6">{{ $item['title'] }}</h2>
                        <p class="type-b3 mt-3">{{ $item['body'] }}</p>
                    </article>
                @endforeach
            </div>
        </section>
    @endforeach
</x-layouts.app>
