@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Press);
    $articles = collect($cms->pressArticles());
    $featured = $articles->firstWhere('featured', true);
    $gridArticles = $articles->reject(fn (array $article): bool => (bool) ($article['featured'] ?? false))->values();
@endphp

<x-layouts.app :title="__('nav.press').' — '.config('app.name')">
    <section class="flex flex-1 flex-col bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto w-full max-w-[100rem]">
            <div class="mx-auto flex max-w-3xl flex-col items-center text-center">
                <h1 class="type-h1">{{ __('nav.press') }}</h1>
                <p class="type-b1 mt-4 max-w-xl lg:mt-6">
                    @if ($cms->enabled())
                        {{ $cms->text('intro', 'press.intro') }}
                    @else
                        {{ __('press.intro') }}
                        <a href="{{ route('contact') }}" class="underline underline-offset-4 transition-opacity duration-300 hover:opacity-40">{{ __('nav.contact') }}</a>.
                    @endif
                </p>
            </div>

            @if ($featured)
                <div class="mt-16 lg:mt-20">
                    <x-press.card
                        :title="$featured['title']"
                        :excerpt="$featured['excerpt']"
                        :publication="$featured['publication']"
                        :logo="$featured['logo'] ?? null"
                        :url="$featured['url'] ?? null"
                        featured
                    />
                </div>
            @endif

            @if ($gridArticles->isNotEmpty())
                <div @class([
                    'grid grid-cols-1 items-stretch gap-8 lg:grid-cols-2 lg:gap-10 xl:gap-12',
                    'mt-8 lg:mt-10' => $featured,
                    'mt-16 lg:mt-20' => ! $featured,
                ])>
                    @foreach ($gridArticles as $article)
                        <x-press.card
                            :title="$article['title']"
                            :excerpt="$article['excerpt']"
                            :publication="$article['publication']"
                            :logo="$article['logo'] ?? null"
                            :url="$article['url'] ?? null"
                        />
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
