@props([
    'video',
    'poster',
])

<section {{ $attributes->class(['site-hero']) }}>
    <x-site-video
        class="absolute inset-0 size-full object-cover object-center"
        preload="metadata"
        aria-hidden="true"
        data-managed
        src="{{ $video }}"
        poster="{{ $poster }}"
    />

    <div class="site-hero__booking" id="booking">
        <div class="site-hero__finder">
            <x-mirai.finder layout="column" :mobile="true" class="w-full" />
            <x-mirai.finder layout="expand" :desktop="true" class="w-full" />
        </div>
    </div>
</section>
