<?php

namespace App\Support;

use App\Enums\CmsPageSlug;
use App\Models\CmsPage;
use App\Models\ErmitaExperience;
use App\Models\ErmitaRoom;
use App\Models\MejoradaExperience;
use App\Models\MejoradaRoom;
use App\Models\PressArticle;
use App\Models\ShopItem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CmsContent
{
    private ?CmsPage $page = null;

    public function __construct(
        private readonly CmsPageSlug|string $slug,
    ) {}

    public static function for(CmsPageSlug|string $slug): self
    {
        return new self($slug);
    }

    public function enabled(): bool
    {
        return (bool) $this->page()?->cms_enabled;
    }

    public function text(string $key, ?string $fallbackKey = null, array $replace = []): string
    {
        $locale = app()->getLocale();

        if ($this->enabled()) {
            $value = data_get($this->page()?->content, "{$locale}.{$key}");

            if (filled($value)) {
                return $this->replace((string) $value, $replace);
            }
        }

        if ($fallbackKey === null) {
            return '';
        }

        return __($fallbackKey, $replace);
    }

    public function asset(string $key, string $fallbackPath): string
    {
        if ($this->enabled()) {
            $path = data_get($this->page()?->content, "media.{$key}");

            if (filled($path)) {
                if (str_starts_with($path, 'http')) {
                    return (string) $path;
                }

                if (str_starts_with($path, 'images/') || str_starts_with($path, 'videos/')) {
                    return $this->publicUrl($path);
                }

                return Storage::disk('public')->url($path);
            }
        }

        return $this->publicUrl($fallbackPath);
    }

    private function publicUrl(string $path): string
    {
        return asset($this->encodePublicPath($path));
    }

    private function encodePublicPath(string $path): string
    {
        return collect(explode('/', ltrim($path, '/')))
            ->map(fn (string $segment): string => rawurlencode($segment))
            ->implode('/');
    }

    /**
     * @return list<string>
     */
    public function gallery(string $key, array $fallbackPaths): array
    {
        if ($this->enabled()) {
            $paths = data_get($this->page()?->content, "media.{$key}");

            if (is_array($paths) && count($paths) > 0) {
                return array_values(array_map(function (mixed $path): string {
                    $path = (string) $path;

                    if (str_starts_with($path, 'http')) {
                        return $path;
                    }

                    if (str_starts_with($path, 'images/') || str_starts_with($path, 'videos/') || str_starts_with($path, 'storage/')) {
                        return $this->encodePublicPath($path);
                    }

                    return $this->encodePublicPath('storage/'.$path);
                }, $paths));
            }
        }

        return array_values(array_map(
            fn (string $path): string => str_starts_with($path, 'http') ? $path : $this->encodePublicPath($path),
            $fallbackPaths,
        ));
    }

    /**
     * @return list<array{title: string, excerpt: string, publication: string, url: ?string, logo: ?string, featured: bool}>
     */
    public function pressArticles(): array
    {
        if ($this->enabled() && PressArticle::query()->published()->exists()) {
            return PressArticle::query()
                ->published()
                ->ordered()
                ->get()
                ->map(fn (PressArticle $article): array => [
                    'title' => $article->localizedTitle(),
                    'excerpt' => $article->localizedExcerpt(),
                    'publication' => $article->publication,
                    'url' => $article->url,
                    'logo' => $article->logoUrl(),
                    'featured' => false,
                ])
                ->all();
        }

        return collect(trans('press.articles'))
            ->map(fn (array $article): array => [
                'title' => $article['title'],
                'excerpt' => $article['excerpt'],
                'publication' => $article['publication'],
                'url' => $article['url'] ?? null,
                'logo' => $article['logo'] ?? null,
                'featured' => (bool) ($article['featured'] ?? false),
            ])
            ->all();
    }

    /**
     * @return list<array{category: string, products: list<array{brand: string, body: string, image: string}>}>
     */
    public function shopItems(): array
    {
        if ($this->enabled() && ShopItem::query()->published()->exists()) {
            return ShopItem::query()
                ->published()
                ->ordered()
                ->get()
                ->map(fn (ShopItem $item): array => [
                    'category' => $item->localizedCategory(),
                    'products' => [[
                        'brand' => $item->localizedBrand(),
                        'body' => $item->localizedBody(),
                        'image' => $item->imageUrl() ?? asset('images/home/ermita.png'),
                    ]],
                ])
                ->all();
        }

        return collect(trans('shop.items'))
            ->map(function (array $item): array {
                if (isset($item['products']) && is_array($item['products'])) {
                    return [
                        'category' => $item['category'],
                        'products' => array_values($item['products']),
                    ];
                }

                return [
                    'category' => $item['category'],
                    'products' => [[
                        'brand' => $item['brand'],
                        'body' => $item['body'],
                        'image' => $item['image'],
                    ]],
                ];
            })
            ->all();
    }

    /**
     * @return list<array{slug: string, image: string, title: string, body: string, detail: string, price: string, size: string, people: int, beds: int, exclusive: list<string>}>
     */
    public function ermitaRooms(): array
    {
        $langBySlug = collect(trans('ermita.rooms_page.items'))->keyBy('slug');

        if ($this->pageEnabled(CmsPageSlug::ErmitaRooms) && ErmitaRoom::query()->published()->exists()) {
            return ErmitaRoom::query()
                ->published()
                ->ordered()
                ->get()
                ->map(function (ErmitaRoom $room) use ($langBySlug): array {
                    $lang = $langBySlug->get($room->slug, []);

                    return [
                        'slug' => $room->slug,
                        'image' => $this->mediaPublicPath($room->image, (string) ($lang['image'] ?? 'images/home/ermita.png')),
                        'title' => $room->localizedTitle() ?: (string) ($lang['title'] ?? ''),
                        'body' => $room->localizedBody() ?: (string) ($lang['body'] ?? ''),
                        'detail' => $room->localizedDetail() ?: (string) ($lang['detail'] ?? ''),
                        'price' => $room->localizedPrice() ?: (string) ($lang['price'] ?? ''),
                        'size' => $room->localizedSize() ?: (string) ($lang['size'] ?? ''),
                        'people' => (int) ($room->people ?: ($lang['people'] ?? 0)),
                        'beds' => (int) ($room->beds ?: ($lang['beds'] ?? 0)),
                        'beds_label' => $lang['beds_label'] ?? null,
                        'exclusive' => array_values(array_filter((array) ($room->exclusive ?? $lang['exclusive'] ?? []))),
                    ];
                })
                ->all();
        }

        return $langBySlug
            ->map(fn (array $room): array => [
                'slug' => $room['slug'],
                'image' => $room['image'],
                'title' => $room['title'],
                'body' => $room['body'],
                'detail' => $room['detail'],
                'price' => $room['price'],
                'size' => $room['size'],
                'people' => (int) $room['people'],
                'beds' => (int) $room['beds'],
                'beds_label' => $room['beds_label'] ?? null,
                'exclusive' => array_values($room['exclusive'] ?? []),
            ])
            ->values()
            ->all();
    }

    /**
     * Homepage rooms carousel items (image, title, body, people, beds).
     *
     * @return list<array{image: string, title: string, body: string, people: int, beds: int}>
     */
    public function ermitaRoomTeasers(): array
    {
        return collect($this->ermitaRooms())
            ->take(3)
            ->map(fn (array $room): array => [
                'slug' => $room['slug'],
                'image' => $room['image'],
                'title' => $room['title'],
                'body' => $room['body'],
                'people' => (int) $room['people'],
                'beds' => (int) $room['beds'],
                'beds_label' => $room['beds_label'] ?? null,
            ])
            ->values()
            ->all();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function ermitaExperiences(): array
    {
        if ($this->pageEnabled(CmsPageSlug::ErmitaExperiences) && ErmitaExperience::query()->published()->exists()) {
            return ErmitaExperience::query()
                ->published()
                ->ordered()
                ->get()
                ->map(fn (ErmitaExperience $experience): array => $this->mapExperienceModel($experience))
                ->all();
        }

        return collect(trans('ermita.experiences_page.items'))
            ->map(fn (array $item): array => $item)
            ->values()
            ->all();
    }

    /**
     * @return list<array{image: string, label: ?string, title: string, body: string}>
     */
    public function ermitaExperienceTeasers(): array
    {
        if ($this->pageEnabled(CmsPageSlug::ErmitaExperiences) && ErmitaExperience::query()->published()->exists()) {
            return collect($this->ermitaExperiences())
                ->take(3)
                ->map(fn (array $item): array => [
                    'image' => $item['image'],
                    'label' => $item['tag'] ?? $item['label'] ?? null,
                    'title' => $item['title'],
                    'body' => $item['body'] ?? '',
                ])
                ->values()
                ->all();
        }

        return collect(trans('ermita.experiences.items'))
            ->map(fn (array $item): array => $item)
            ->values()
            ->all();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function listItems(string $key, string $fallbackLangKey): array
    {
        $locale = app()->getLocale();

        if ($this->enabled()) {
            $items = data_get($this->page()?->content, "{$locale}.{$key}");
            $esItems = data_get($this->page()?->content, "es.{$key}");

            if (is_array($items) && count($items) > 0) {
                return collect($items)
                    ->values()
                    ->map(function (mixed $item, int $index) use ($esItems): array {
                        $item = is_array($item) ? $item : [];
                        $esItem = is_array($esItems[$index] ?? null) ? $esItems[$index] : [];

                        $image = $item['image'] ?? $esItem['image'] ?? null;
                        $perks = $item['perks'] ?? $esItem['perks'] ?? [];

                        if (is_string($perks)) {
                            $perks = preg_split("/\r\n|\n|\r/", $perks) ?: [];
                        }

                        $body = $item['body'] ?? null;
                        if (blank($body) && isset($item['paragraphs']) && is_array($item['paragraphs'])) {
                            $body = implode(' ', array_filter($item['paragraphs']));
                        }

                        $normalized = [
                            'image' => $this->mediaPublicPath(
                                filled($image) ? (string) $image : null,
                                'images/home/ermita.png'
                            ),
                            'title' => (string) ($item['title'] ?? ''),
                            'body' => (string) ($body ?? ''),
                            'dates' => (string) ($item['dates'] ?? ''),
                            'perks' => array_values(array_filter(array_map(
                                fn (mixed $perk): string => trim((string) $perk),
                                is_array($perks) ? $perks : [],
                            ))),
                        ];

                        foreach (['label', 'tag', 'subtitle', 'cta', 'cta_url', 'video'] as $optional) {
                            if (filled($item[$optional] ?? null)) {
                                $normalized[$optional] = $item[$optional];
                            }
                        }

                        return $normalized;
                    })
                    ->filter(fn (array $item): bool => filled($item['title']) || filled($item['image']))
                    ->values()
                    ->all();
            }
        }

        $fallback = trans($fallbackLangKey);

        return collect(is_array($fallback) ? $fallback : [])
            ->map(fn (array $item): array => $item)
            ->values()
            ->all();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function offers(string $fallbackLangKey = 'ermita.offers_section.items'): array
    {
        return $this->listItems('offers.items', $fallbackLangKey);
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function venueSpaces(string $fallbackLangKey): array
    {
        return $this->listItems('venue.spaces', $fallbackLangKey);
    }

    /**
     * @return list<array{slug: string, image: string, title: string, body: string, detail: string, price: string, size: string, people: int, beds: int, exclusive: list<string>}>
     */
    public function mejoradaRooms(): array
    {
        $langBySlug = collect(trans('mejorada.rooms_page.items'))->keyBy('slug');

        if ($this->pageEnabled(CmsPageSlug::MejoradaRooms) && MejoradaRoom::query()->published()->exists()) {
            return MejoradaRoom::query()
                ->published()
                ->ordered()
                ->get()
                ->map(function (MejoradaRoom $room) use ($langBySlug): array {
                    $lang = $langBySlug->get($room->slug, []);

                    return [
                        'slug' => $room->slug,
                        'image' => $this->mediaPublicPath($room->image, (string) ($lang['image'] ?? 'images/home/ermita.png')),
                        'title' => $room->localizedTitle() ?: (string) ($lang['title'] ?? ''),
                        'body' => $room->localizedBody() ?: (string) ($lang['body'] ?? ''),
                        'detail' => $room->localizedDetail() ?: (string) ($lang['detail'] ?? ''),
                        'price' => $room->localizedPrice() ?: (string) ($lang['price'] ?? ''),
                        'size' => $room->localizedSize() ?: (string) ($lang['size'] ?? ''),
                        'people' => (int) ($room->people ?: ($lang['people'] ?? 0)),
                        'beds' => (int) ($room->beds ?: ($lang['beds'] ?? 0)),
                        'beds_label' => $lang['beds_label'] ?? null,
                        'exclusive' => array_values(array_filter((array) ($room->exclusive ?? $lang['exclusive'] ?? []))),
                    ];
                })
                ->values()
                ->all();
        }

        return $langBySlug
            ->map(fn (array $room): array => [
                'slug' => $room['slug'],
                'image' => $room['image'],
                'title' => $room['title'],
                'body' => $room['body'],
                'detail' => $room['detail'],
                'price' => $room['price'],
                'size' => $room['size'],
                'people' => (int) $room['people'],
                'beds' => (int) $room['beds'],
                'beds_label' => $room['beds_label'] ?? null,
                'exclusive' => array_values($room['exclusive'] ?? []),
            ])
            ->values()
            ->all();
    }

    /**
     * Homepage rooms carousel items (image, title, body, people, beds).
     *
     * @return list<array{image: string, title: string, body: string, people: int, beds: int}>
     */
    public function mejoradaRoomTeasers(): array
    {
        return collect($this->mejoradaRooms())
            ->take(3)
            ->map(fn (array $room): array => [
                'slug' => $room['slug'],
                'image' => $room['image'],
                'title' => $room['title'],
                'body' => $room['body'],
                'people' => (int) $room['people'],
                'beds' => (int) $room['beds'],
                'beds_label' => $room['beds_label'] ?? null,
            ])
            ->values()
            ->all();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function mejoradaExperiences(): array
    {
        if ($this->pageEnabled(CmsPageSlug::MejoradaExperiences) && MejoradaExperience::query()->published()->exists()) {
            return MejoradaExperience::query()
                ->published()
                ->ordered()
                ->get()
                ->map(fn (MejoradaExperience $experience): array => $this->mapExperienceModel($experience))
                ->all();
        }

        return collect(trans('mejorada.experiences_page.items'))
            ->map(fn (array $item): array => $item)
            ->values()
            ->all();
    }

    /**
     * @return list<array{image: string, label: ?string, title: string, body: string}>
     */
    public function mejoradaExperienceTeasers(): array
    {
        if ($this->pageEnabled(CmsPageSlug::MejoradaExperiences) && MejoradaExperience::query()->published()->exists()) {
            return collect($this->mejoradaExperiences())
                ->take(3)
                ->map(fn (array $item): array => [
                    'image' => $item['image'],
                    'label' => $item['tag'] ?? $item['label'] ?? null,
                    'title' => $item['title'],
                    'body' => $item['body'] ?? '',
                ])
                ->values()
                ->all();
        }

        return collect(trans('mejorada.experiences.items'))
            ->map(fn (array $item): array => $item)
            ->values()
            ->all();
    }

    /**
     * Home carousel: prefer published hotel experiences when their CMS pages are on; else lang.
     *
     * @return list<array{image: string, label: ?string, title: string, body: string, video?: string}>
     */
    public function homeExperienceTeasers(): array
    {
        $ermita = self::for(CmsPageSlug::ErmitaExperiences)->ermitaExperienceTeasers();
        $mejorada = self::for(CmsPageSlug::MejoradaExperiences)->mejoradaExperienceTeasers();

        $fromCms = collect($ermita)
            ->merge($mejorada)
            ->unique(fn (array $item): string => mb_strtolower((string) ($item['title'] ?? '')))
            ->take(3)
            ->values()
            ->all();

        if (
            count($fromCms) > 0
            && (
                self::for(CmsPageSlug::ErmitaExperiences)->enabled()
                || self::for(CmsPageSlug::MejoradaExperiences)->enabled()
            )
            && (
                ErmitaExperience::query()->published()->exists()
                || MejoradaExperience::query()->published()->exists()
            )
        ) {
            return $fromCms;
        }

        return collect(trans('home.experiences.items'))
            ->map(fn (array $item): array => $item)
            ->values()
            ->all();
    }

    private function pageEnabled(CmsPageSlug $slug): bool
    {
        return self::for($slug)->enabled();
    }

    /**
     * @param  ErmitaExperience|MejoradaExperience  $experience
     * @return array<string, mixed>
     */
    private function mapExperienceModel(ErmitaExperience|MejoradaExperience $experience): array
    {
        $paragraphs = $experience->localizedParagraphs();
        $body = implode(' ', $paragraphs);

        $item = [
            'image' => $this->mediaPublicPath($experience->image, 'images/home/ermita.png'),
            'title' => $experience->localizedTitle(),
            'body' => $body,
            'paragraphs' => $paragraphs,
        ];

        if (filled($experience->localizedTag())) {
            $item['tag'] = $experience->localizedTag();
            $item['label'] = $experience->localizedTag();
        }

        if (filled($experience->localizedSubtitle())) {
            $item['subtitle'] = $experience->localizedSubtitle();
        }

        if (filled($experience->localizedSubtitleBody())) {
            $item['subtitle_body'] = $experience->localizedSubtitleBody();
        }

        if ($experience->expandable) {
            $item['expandable'] = true;
        }

        if (filled($experience->localizedCta())) {
            $item['cta'] = $experience->localizedCta();
        }

        if (filled($experience->cta_url)) {
            $item['cta_url'] = $experience->cta_url;
        }

        if (filled($experience->video)) {
            $video = (string) $experience->video;
            $item['video'] = str_starts_with($video, 'videos/')
                ? basename($video)
                : (str_contains($video, '/') ? basename($video) : $video);
        }

        return $item;
    }

    private function mediaPublicPath(?string $path, string $fallback): string
    {
        if (blank($path)) {
            return $fallback;
        }

        if (str_starts_with($path, 'http') || str_starts_with($path, 'images/') || str_starts_with($path, 'videos/') || str_starts_with($path, 'storage/')) {
            return $path;
        }

        return 'storage/'.$path;
    }

    private function page(): ?CmsPage
    {
        if ($this->page !== null) {
            return $this->page;
        }

        $slug = $this->slug instanceof CmsPageSlug ? $this->slug->value : $this->slug;

        try {
            return $this->page = Cache::remember(
                "cms.page.{$slug}",
                now()->addMinutes(5),
                fn (): ?CmsPage => CmsPage::query()->where('slug', $slug)->first(),
            );
        } catch (\Throwable) {
            return $this->page = null;
        }
    }

    private function replace(string $value, array $replace): string
    {
        foreach ($replace as $key => $replacement) {
            $value = str_replace(':'.$key, (string) $replacement, $value);
        }

        return $value;
    }
}
