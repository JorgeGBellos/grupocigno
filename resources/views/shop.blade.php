@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Shop);
@endphp

<x-layouts.app :title="$cms->text('title', 'shop.title').' — '.config('app.name')">
    <section class="flex flex-1 flex-col bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto w-full max-w-6xl">
            <div class="mx-auto flex max-w-3xl flex-col items-center text-center">
                <h1 class="type-h1">{{ $cms->text('title', 'shop.title') }}</h1>

                <div class="type-b2 mt-6 max-w-2xl space-y-4">
                    <p>{{ $cms->text('lead_1', 'shop.lead_1') }}</p>
                    <p>{{ $cms->text('lead_2', 'shop.lead_2') }}</p>
                </div>
            </div>

            <div class="mt-16 grid grid-cols-1 items-stretch gap-16 lg:mt-20 lg:grid-cols-2 lg:gap-x-12 lg:gap-y-20 [&>*:last-child:nth-child(odd)]:lg:col-span-2 [&>*:last-child:nth-child(odd)]:lg:w-[calc(50%-1.5rem)] [&>*:last-child:nth-child(odd)]:lg:justify-self-center">
                @foreach ($cms->shopItems() as $item)
                    <x-shop.item
                        :category="$item['category']"
                        :products="$item['products']"
                    />
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
