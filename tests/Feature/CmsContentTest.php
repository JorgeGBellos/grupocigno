<?php

namespace Tests\Feature;

use App\Models\CmsPage;
use App\Models\PressArticle;
use Tests\TestCase;

class CmsContentTest extends TestCase
{
    public function test_it_uses_fallback_copy_when_cms_is_disabled(): void
    {
        $this->assertSame(__('home.hero.line_1'), cms('home')->text('hero.line_1', 'home.hero.line_1'));
    }

    public function test_it_uses_cms_copy_when_enabled_and_field_is_filled(): void
    {
        $page = CmsPage::query()->where('slug', 'home')->firstOrFail();
        $page->update([
            'cms_enabled' => true,
            'content' => [
                'es' => [
                    'hero' => [
                        'line_1' => 'Texto CMS',
                    ],
                ],
            ],
        ]);

        $this->assertSame('Texto CMS', cms('home')->text('hero.line_1', 'home.hero.line_1'));
    }

    public function test_press_articles_fallback_to_lang_when_cms_is_disabled(): void
    {
        $articles = cms('press')->pressArticles();

        $this->assertCount(count(trans('press.articles')), $articles);
        $this->assertSame(trans('press.articles.0.title'), $articles[0]['title']);
    }

    public function test_press_articles_use_database_when_cms_is_enabled(): void
    {
        CmsPage::query()->where('slug', 'press')->update(['cms_enabled' => true]);

        PressArticle::query()->create([
            'title' => ['es' => 'Artículo CMS', 'en' => 'CMS Article'],
            'excerpt' => ['es' => 'Extracto CMS', 'en' => 'CMS excerpt'],
            'publication' => 'Test',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $articles = cms('press')->pressArticles();

        $this->assertCount(1, $articles);
        $this->assertSame('Artículo CMS', $articles[0]['title']);
    }
}
