@props([
    'title' => null,
    'lead' => null,
    'items' => null,
    'mark' => 'images/home/Swan (1).svg',
    'banner' => false,
])

@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Ermita);
    $title ??= $cms->text('amenities.title', 'ermita.amenities.title');
    $lead ??= $cms->text('amenities.lead', 'ermita.amenities.lead');
    $items ??= __('ermita.amenities.items');
@endphp
<section @if (! $banner) {{ $attributes->class(['bg-blue-ermita-300 px-6 py-16 text-white sm:py-20 lg:px-10 lg:py-28']) }} @endif>
    @if ($banner)
        <div class="bg-beige-500 text-black-500">
            <img
                src="{{ asset('images/ermita/daypass/tiles.png') }}"
                alt=""
                class="aspect-[21/9] w-full object-cover"
            >

            <div class="mx-auto flex max-w-5xl flex-col items-center px-6 py-16 text-center sm:py-20 lg:py-24">
                <h2 class="type-h2 max-sm:whitespace-normal sm:whitespace-nowrap">{{ $lead }}</h2>

                <div class="mt-12 flex w-full flex-wrap items-start justify-center gap-20 sm:mt-16">
                    @foreach ($items as $item)
                        <div class="flex w-auto max-w-[6.5rem] flex-col items-center">
                            <img
                                src="{{ asset($item['icon']) }}"
                                alt=""
                                width="56"
                                height="56"
                                class="h-14 w-auto max-w-[4.5rem]"
                            >
                            <p class="type-b2 mt-5">{{ $item['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
    <div class="mx-auto flex max-w-5xl flex-col items-center text-center">
        <img
            src="{{ str_starts_with($mark, 'http') || str_starts_with($mark, '/') ? $mark : asset($mark) }}"
            alt=""
            width="72"
            class="h-auto w-[56px] brightness-0 invert sm:w-[72px]"
        >

        <h2 class="type-h1 mt-8 text-white">{{ $title }}</h2>
        <p class="type-b2 mt-4 max-w-xl text-white">{{ $lead }}</p>

        <div @class([
            'mt-12 grid w-full gap-8 sm:mt-16 sm:gap-10 lg:mt-20 lg:gap-12',
            'grid-cols-2 md:grid-cols-3 lg:grid-cols-6' => count($items) === 6,
            'grid-cols-2 lg:grid-cols-4' => count($items) !== 6,
        ])>
            @foreach ($items as $item)
                <div class="flex flex-col items-center">
                    <img
                        src="{{ asset($item['icon']) }}"
                        alt=""
                        width="56"
                        height="56"
                        class="h-14 w-auto max-w-[4.5rem] brightness-0 invert"
                    >
                    <p class="type-label mt-5 text-white">{{ $item['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</section>
