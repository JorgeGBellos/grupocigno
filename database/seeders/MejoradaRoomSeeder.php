<?php

namespace Database\Seeders;

use App\Models\MejoradaRoom;
use Illuminate\Database\Seeder;

class MejoradaRoomSeeder extends Seeder
{
    public function run(): void
    {
        $esItems = trans('mejorada.rooms_page.items', [], 'es');
        $enItems = trans('mejorada.rooms_page.items', [], 'en');

        if (! is_array($esItems)) {
            return;
        }

        $enMap = collect(is_array($enItems) ? $enItems : [])->keyBy('slug');

        foreach ($esItems as $index => $room) {
            $enRoom = $enMap->get($room['slug'], []);

            MejoradaRoom::query()->updateOrCreate(
                ['slug' => $room['slug']],
                [
                    'sort_order' => $index,
                    'is_published' => true,
                    'people' => (int) $room['people'],
                    'beds' => (int) $room['beds'],
                    'exclusive' => array_values($room['exclusive'] ?? []),
                    'image' => $room['image'] ?? null,
                    'title' => [
                        'es' => $room['title'],
                        'en' => $enRoom['title'] ?? $room['title'],
                    ],
                    'body' => [
                        'es' => $room['body'],
                        'en' => $enRoom['body'] ?? $room['body'],
                    ],
                    'detail' => [
                        'es' => $room['detail'],
                        'en' => $enRoom['detail'] ?? $room['detail'],
                    ],
                    'price' => [
                        'es' => $room['price'],
                        'en' => $enRoom['price'] ?? $room['price'],
                    ],
                    'size' => [
                        'es' => $room['size'],
                        'en' => $enRoom['size'] ?? $room['size'],
                    ],
                ]
            );
        }
    }
}
