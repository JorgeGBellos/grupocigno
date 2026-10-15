<?php

namespace Database\Seeders;

use App\Enums\CmsPageSlug;
use App\Models\CmsPage;
use Illuminate\Database\Seeder;

class CmsPageSeeder extends Seeder
{
    public function run(): void
    {
        foreach (CmsPageSlug::cases() as $slug) {
            CmsPage::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $slug->label(),
                    'cms_enabled' => false,
                    'content' => [],
                ],
            );
        }
    }
}
