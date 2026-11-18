<?php

namespace Database\Seeders;

use App\Models\ErmitaRoom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ErmitaRoomSeeder extends Seeder
{
    public function run(): void
    {
        $esItems = trans('ermita.rooms_page.items', [], 'es');
        $enItems = trans('ermita.rooms_page.items', [], 'en');

        if (! is_array($esItems)) {
            return;
        }

        $enMap = collect(is_array($enItems) ? $enItems : [])->keyBy('slug');

        foreach ($esItems as $index => $room) {
            $slug = $room['slug'] ?? Str::slug((string) ($room['title'] ?? 'room-'.$index));
            $enRoom = $enMap->get($slug, []);

            ErmitaRoom::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'sort_order' => $index,
                    'is_published' => true,
                    'people' => (int) ($room['people'] ?? 0),
                    'beds' => (int) ($room['beds'] ?? 0),
                    'exclusive' => array_values($room['exclusive'] ?? []),
                    'image' => $room['image'] ?? null,
                    'title' => [
                        'es' => $room['title'] ?? '',
                        'en' => $enRoom['title'] ?? ($room['title'] ?? ''),
                    ],
                    'body' => [
                        'es' => $room['body'] ?? '',
                        'en' => $enRoom['body'] ?? ($room['body'] ?? ''),
                    ],
                    'detail' => [
                        'es' => $room['detail'] ?? '',
                        'en' => $enRoom['detail'] ?? ($room['detail'] ?? ''),
                    ],
                    'price' => [
                        'es' => $room['price'] ?? '',
                        'en' => $enRoom['price'] ?? ($room['price'] ?? ''),
                    ],
                    'size' => [
                        'es' => $room['size'] ?? '',
                        'en' => $enRoom['size'] ?? ($room['size'] ?? ''),
                    ],
                ]
            );
        }
    }
}
