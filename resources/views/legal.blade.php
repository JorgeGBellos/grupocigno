@php
    use App\Enums\CmsPageSlug;

    $page = CmsPageSlug::from($cmsSlug);
    $cms = cms($page);
    $title = $cms->text('title', $page->titleFallbackKey());
    $body = $cms->text('body', $page->bodyFallbackKey());
@endphp

<x-layouts.app :title="$title.' — '.config('app.name')">
    <section class="flex flex-1 flex-col bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto w-full max-w-3xl">
            <p class="type-label text-black-300">{{ __('pages.legal_label') }}</p>

            <h1 class="type-h1 mt-4">{{ $title }}</h1>

            <p class="type-b3 mt-4 text-black-300">{{ __('pages.last_updated') }}</p>

            <x-legal.body :content="$body" class="type-b2 mt-10 max-w-none leading-relaxed" />
        </div>
    </section>
</x-layouts.app>
