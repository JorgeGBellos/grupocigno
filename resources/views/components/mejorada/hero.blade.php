@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Mejorada);
@endphp

<x-site-hero
    :video="$cms->asset('hero.video', 'videos/mejorada-home.mp4')"
    :poster="$cms->asset('hero.background', 'images/home/Home (1).png')"
/>
