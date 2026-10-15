<?php

namespace App\Support;

use App\Enums\CmsPageSlug;
use App\Models\CmsPage;
use App\Models\ErmitaExperience;
use App\Models\ErmitaRoom;
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
                if (str_starts_with($path, 'http') || str_starts_with($path, 'images/') || str_starts_with($path, 'videos/')) {
                    return asset($path);
                }

                return Storage::disk('public')->url($path);
            }
        }

        return asset($fallbackPath);
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

                    if (str_starts_with($path, 'http') || str_starts_with($path, 'images/')) {
                        return $path;
                    }

                    return 'storage/'.$path;
                }, $paths));
            }
        }

        return $fallbackPaths;
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
        if ($this->pageEnabled(CmsPageSlug::ErmitaRooms) && ErmitaRoom::query()->published()->exists()) {
            return ErmitaRoom::query()
                ->published()
                ->ordered()
                ->get()
                ->map(fn (ErmitaRoom $room): array => [
                    'slug' => $room->slug,
                    'image' => $this->mediaPublicPath($room->image, 'images/home/ermita.png'),
                    'title' => $room->localizedTitle(),
                    'body' => $room->localizedBody(),
                    'detail' => $room->localizedDetail(),
                    'price' => $room->localizedPrice(),
                    'size' => $room->localizedSize(),
                    'people' => (int) $room->people,
                    'beds' => (int) $room->beds,
                    'exclusive' => array_values(array_filter((array) ($room->exclusive ?? []))),
                ])
                ->all();
        }

        return collect(trans('ermita.rooms_page.items'))
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
                'exclusive' => array_values($room['exclusive'] ?? []),
            ])
            ->all();
    }

    /**
     * Homepage rooms carousel items (image, title, body, people, beds).
     *
     * @return list<array{image: string, title: string, body: string, people: int, beds: int}>
     */
    public function ermitaRoomTeasers(): array
    {
        if ($this->pageEnabled(CmsPageSlug::ErmitaRooms) && ErmitaRoom::query()->published()->exists()) {
            return ErmitaRoom::query()
                ->published()
                ->ordered()
                ->get()
                ->map(fn (ErmitaRoom $room): array => [
                    'image' => $this->mediaPublicPath($room->image, 'images/home/ermita.png'),
                    'title' => $room->localizedTitle(),
                    'body' => $room->localizedBody(),
                    'people' => (int) $room->people,
                    'beds' => (int) $room->beds,
                ])
                ->all();
        }

        return collect(trans('ermita.rooms.items'))
            ->map(fn (array $room): array => [
                'image' => $room['image'],
                'title' => $room['title'],
                'body' => $room['body'],
                'people' => (int) $room['people'],
                'beds' => (int) $room['beds'],
            ])
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
                ->map(function (ErmitaExperience $experience): array {
                    $item = [
                        'image' => $this->mediaPublicPath($experience->image, 'images/home/ermita.png'),
                        'title' => $experience->localizedTitle(),
                        'paragraphs' => $experience->localizedParagraphs(),
                    ];

                    if (filled($experience->localizedTag())) {
                        $item['tag'] = $experience->localizedTag();
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

                    return $item;
                })
                ->all();
        }

        return collect(trans('ermita.experiences_page.items'))
            ->map(fn (array $item): array => $item)
            ->values()
            ->all();
    }

    /**
     * @return list<array{slug: string, image: string, title: string, body: string, detail: string, price: string, size: string, people: int, beds: int, exclusive: list<string>}>
     */
    public function mejoradaRooms(): array
    {
        if (MejoradaRoom::query()->published()->exists()) {
            return MejoradaRoom::query()
                ->published()
                ->ordered()
                ->get()
                ->map(fn (MejoradaRoom $room): array => [
                    'slug' => $room->slug,
                    'image' => $this->mediaPublicPath($room->image, 'images/home/ermita.png'),
                    'title' => $room->localizedTitle(),
                    'body' => $room->localizedBody(),
                    'detail' => $room->localizedDetail(),
                    'price' => $room->localizedPrice(),
                    'size' => $room->localizedSize(),
                    'people' => (int) $room->people,
                    'beds' => (int) $room->beds,
                    'exclusive' => array_values(array_filter((array) ($room->exclusive ?? []))),
                ])
                ->all();
        }

        return collect(trans('mejorada.rooms_page.items'))
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
                'exclusive' => array_values($room['exclusive'] ?? []),
            ])
            ->all();
    }

    /**
     * Homepage rooms carousel items (image, title, body, people, beds).
     *
     * @return list<array{image: string, title: string, body: string, people: int, beds: int}>
     */
    public function mejoradaRoomTeasers(): array
    {
        if (MejoradaRoom::query()->published()->exists()) {
            return MejoradaRoom::query()
                ->published()
                ->ordered()
                ->get()
                ->map(fn (MejoradaRoom $room): array => [
                    'image' => $this->mediaPublicPath($room->image, 'images/home/ermita.png'),
                    'title' => $room->localizedTitle(),
                    'body' => $room->localizedBody(),
                    'people' => (int) $room->people,
                    'beds' => (int) $room->beds,
                ])
                ->all();
        }

        return collect(trans('mejorada.rooms_page.items'))
            ->take(3)
            ->map(fn (array $room): array => [
                'image' => $room['image'],
                'title' => $room['title'],
                'body' => $room['body'],
                'people' => (int) $room['people'],
                'beds' => (int) $room['beds'],
            ])
            ->all();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function mejoradaExperiences(): array
    {
        return collect(trans('mejorada.experiences_page.items'))
            ->map(fn (array $item): array => $item)
            ->values()
            ->all();
    }

    private function pageEnabled(CmsPageSlug $slug): bool
    {
        return self::for($slug)->enabled();
    }

    private function mediaPublicPath(?string $path, string $fallback): string
    {
        if (blank($path)) {
            return $fallback;
        }

        if (str_starts_with($path, 'http') || str_starts_with($path, 'images/') || str_starts_with($path, 'storage/')) {
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
