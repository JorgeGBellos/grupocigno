@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Home);

    $clubItems = [
        [
            'icon' => 'images/home/Layer_1 (55).svg',
            'title' => $cms->text('club.discount_title', 'home.club.discount_title'),
            'body' => $cms->text('club.discount_body', 'home.club.discount_body'),
        ],
        [
            'icon' => 'images/home/Layer_1 (56).svg',
            'title' => $cms->text('club.gifts_title', 'home.club.gifts_title'),
            'body' => $cms->text('club.gifts_body', 'home.club.gifts_body'),
        ],
        [
            'icon' => 'images/home/Layer_1 (57).svg',
            'title' => $cms->text('club.vip_title', 'home.club.vip_title'),
            'body' => $cms->text('club.vip_body', 'home.club.vip_body'),
        ],
    ];
@endphp

<section class="relative isolate flex min-h-[750px] items-center overflow-hidden px-6 py-16 text-white lg:px-10 lg:py-24">
    <img
        src="{{ $cms->asset('club.background', 'images/home/Cigno Club (1).png') }}"
        alt=""
        class="absolute inset-0 size-full object-cover"
    >

    <div class="relative z-10 mx-auto flex w-full max-w-5xl flex-col items-center text-center">
        <h1 class="type-h1 text-white">
            {{ $cms->text('club.title', 'home.club.title') }}
        </h1>

        <div class="type-b1 mt-6 max-w-xl space-y-1 text-white">
            <p>{{ $cms->text('club.line_1', 'home.club.line_1') }}</p>
            <p>{{ $cms->text('club.line_2', 'home.club.line_2') }}</p>
        </div>

        <div class="mt-14 grid w-full grid-cols-1 gap-12 md:grid-cols-3 md:gap-10 lg:mt-16">
            @foreach ($clubItems as $item)
                <div class="flex flex-col items-center">
                    <img
                        src="{{ asset($item['icon']) }}"
                        alt=""
                        width="62"
                        height="90"
                        class="h-[90px] w-auto"
                    >

                    <h3 class="type-h3 mt-6 text-white">{{ $item['title'] }}</h3>
                    <p class="type-b3 mt-3 max-w-xs text-white">{{ $item['body'] }}</p>
                </div>
            @endforeach
        </div>

        <p class="type-label mt-14 text-white lg:mt-16">
            {{ $cms->text('club.vip_note', 'home.club.vip_note') }}
        </p>
    </div>
</section>
