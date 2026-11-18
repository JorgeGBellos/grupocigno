<?php

namespace App\Console\Commands;

use App\Cms\PageFieldDefinitions;
use App\Enums\CmsPageSlug;
use App\Models\CmsPage;
use Illuminate\Console\Command;

class ImportCmsFromLang extends Command
{
    protected $signature = 'cms:import-lang
        {slug : CmsPageSlug value, e.g. cigno-ermita-offers}
        {--enable : Also set cms_enabled=true after import}
        {--force : Overwrite existing non-empty CMS values}';

    protected $description = 'Import text fallbacks from lang/ into a CMS page content JSON (helps activate switch without rewriting by hand)';

    public function handle(): int
    {
        $slugValue = (string) $this->argument('slug');
        $slug = CmsPageSlug::tryFrom($slugValue);

        if (! $slug) {
            $this->error("Unknown CMS slug: {$slugValue}");

            return self::FAILURE;
        }

        $page = CmsPage::query()->firstOrCreate(
            ['slug' => $slug],
            [
                'name' => $slug->label(),
                'cms_enabled' => false,
                'content' => [],
            ],
        );

        $content = $page->content ?? [];
        $force = (bool) $this->option('force');
        $imported = 0;

        foreach (['es', 'en'] as $locale) {
            app()->setLocale($locale);

            foreach (PageFieldDefinitions::sections($slug) as $section) {
                foreach ($section['fields'] as $field) {
                    $type = $field['type'] ?? 'text';
                    $key = $field['key'];
                    $fallback = $field['fallback'] ?? null;

                    if (in_array($type, ['image', 'gallery', 'video'], true)) {
                        continue;
                    }

                    if ($type === 'repeater') {
                        if (! filled($fallback)) {
                            continue;
                        }

                        $items = trans($fallback, [], $locale);
                        if (! is_array($items) || $items === []) {
                            continue;
                        }

                        $normalized = collect($items)
                            ->map(function (array $item): array {
                                $perks = $item['perks'] ?? [];
                                if (is_array($perks)) {
                                    $perks = implode("\n", $perks);
                                }

                                return array_filter([
                                    'image' => $item['image'] ?? null,
                                    'title' => $item['title'] ?? null,
                                    'dates' => $item['dates'] ?? null,
                                    'body' => $item['body'] ?? null,
                                    'perks' => $perks ?: null,
                                ], fn (mixed $value): bool => filled($value));
                            })
                            ->values()
                            ->all();

                        $path = "{$locale}.{$key}";
                        $existing = data_get($content, $path);

                        if ($force || blank($existing) || (is_array($existing) && $existing === [])) {
                            data_set($content, $path, $normalized);
                            $imported++;
                        }

                        continue;
                    }

                    if (! filled($fallback) || str_starts_with((string) $fallback, 'images/') || str_starts_with((string) $fallback, 'videos/')) {
                        continue;
                    }

                    $value = trans($fallback, [], $locale);
                    if (! is_string($value) || $value === $fallback || $value === '') {
                        continue;
                    }

                    $path = "{$locale}.{$key}";
                    $existing = data_get($content, $path);

                    if ($force || blank($existing)) {
                        data_set($content, $path, $value);
                        $imported++;
                    }
                }
            }
        }

        $page->content = $content;

        if ($this->option('enable')) {
            $page->cms_enabled = true;
        }

        $page->save();

        $this->info("Imported {$imported} field(s) into {$slug->value}".($this->option('enable') ? ' (cms_enabled=true)' : '').'.');

        return self::SUCCESS;
    }
}
