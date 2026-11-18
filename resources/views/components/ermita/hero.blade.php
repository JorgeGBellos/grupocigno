@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Ermita);
@endphp

<x-site-hero
    :video="$cms->asset('hero.video', 'videos/ermita-home.mp4')"
    :poster="$cms->asset('hero.background', 'images/ermita/home/banner.png')"
/>
