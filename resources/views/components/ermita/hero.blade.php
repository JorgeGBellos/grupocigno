@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Ermita);
@endphp

<section class="relative isolate h-[calc(100svh-var(--header-height))] overflow-hidden text-white">
    <x-site-video
        class="absolute inset-0 size-full object-cover object-center"
        preload="metadata"
        aria-hidden="true"
        data-managed
        src="{{ $cms->asset('hero.video', 'videos/02. Video ERMITA Web Cignos (1).mp4') }}"
        poster="{{ $cms->asset('hero.background', 'images/ermita/home/banner.png') }}"
    />

    <div class="relative z-10 flex h-full flex-col justify-end px-6 pb-[max(1.5rem,env(safe-area-inset-bottom))] lg:px-10 lg:pb-10" id="booking">
        <div class="mx-auto w-full max-w-[900px] lg:max-w-[105rem]">
            <x-mirai.finder layout="column" :mobile="true" class="w-full" />
            <x-mirai.finder layout="expand" :desktop="true" class="w-full" />
        </div>
    </div>
</section>
