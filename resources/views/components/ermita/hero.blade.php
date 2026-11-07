@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Ermita);
@endphp

<x-site-hero
    :video="$cms->asset('hero.video', 'videos/02. Video ERMITA Web Cignos (1).mp4')"
    :poster="$cms->asset('hero.background', 'images/ermita/home/banner.png')"
/>
