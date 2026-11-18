<?php

namespace Database\Seeders;

use App\Models\MejoradaExperience;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MejoradaExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $esItems = trans('mejorada.experiences_page.items', [], 'es');
        $enItems = trans('mejorada.experiences_page.items', [], 'en');

        if (! is_array($esItems)) {
            return;
        }

        $enItems = is_array($enItems) ? array_values($enItems) : [];

        foreach ($esItems as $index => $item) {
            $enItem = $enItems[$index] ?? [];
            $titleEs = (string) ($item['title'] ?? 'experiencia-'.$index);
            $slug = Str::slug($titleEs);

            MejoradaExperience::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'sort_order' => $index,
                    'is_published' => true,
                    'image' => $item['image'] ?? null,
                    'video' => $item['video'] ?? null,
                    'expandable' => false,
                    'title' => [
                        'es' => $titleEs,
                        'en' => (string) ($enItem['title'] ?? $titleEs),
                    ],
                    'paragraphs' => [
                        'es' => array_values(array_filter([(string) ($item['body'] ?? '')])),
                        'en' => array_values(array_filter([(string) ($enItem['body'] ?? $item['body'] ?? '')])),
                    ],
                    'tag' => [
                        'es' => (string) ($item['label'] ?? $item['tag'] ?? ''),
                        'en' => (string) ($enItem['label'] ?? $enItem['tag'] ?? $item['label'] ?? $item['tag'] ?? ''),
                    ],
                ]
            );
        }
    }
}
