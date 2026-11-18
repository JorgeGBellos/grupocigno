<?php

namespace Tests\Feature;

use App\Models\CmsPage;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CmsImportLangCommandTest extends TestCase
{
    public function test_import_lang_fills_offers_page_and_can_enable(): void
    {
        Artisan::call('cms:import-lang', [
            'slug' => 'cigno-ermita-offers',
            '--enable' => true,
        ]);

        $page = CmsPage::query()->where('slug', 'cigno-ermita-offers')->firstOrFail();

        $this->assertTrue($page->cms_enabled);
        $this->assertNotEmpty(data_get($page->content, 'es.offers.page_title'));
        $this->assertIsArray(data_get($page->content, 'es.offers.items'));
        $this->assertNotEmpty(data_get($page->content, 'es.offers.items'));
    }
}
