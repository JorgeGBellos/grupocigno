@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Mejorada);
@endphp

<x-site-hero
    :video="$cms->asset('hero.video', 'videos/03. Video MEJORADA Web Cignos.mp4')"
    :poster="$cms->asset('hero.background', 'images/home/Home (1).png')"
/>
