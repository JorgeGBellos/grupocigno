<?php

namespace Tests\Feature;

use App\Models\CmsPage;
use App\Models\ErmitaExperience;
use App\Models\MejoradaExperience;
use Database\Seeders\ErmitaExperienceSeeder;
use Database\Seeders\MejoradaExperienceSeeder;
use Tests\TestCase;

class CmsExperiencesOffersTest extends TestCase
{
    public function test_ermita_experiences_fallback_to_lang_when_cms_off(): void
    {
        $items = cms('cigno-ermita-experiences')->ermitaExperiences();

        $this->assertNotEmpty($items);
        $this->assertSame(trans('ermita.experiences_page.items.0.title'), $items[0]['title']);
    }

    public function test_ermita_experiences_use_database_when_cms_on(): void
    {
        CmsPage::query()->where('slug', 'cigno-ermita-experiences')->update(['cms_enabled' => true]);

        ErmitaExperience::query()->create([
            'slug' => 'exp-cms-test',
            'sort_order' => 1,
            'is_published' => true,
            'image' => 'images/home/ermita.png',
            'video' => 'experience-gastro.mp4',
            'title' => ['es' => 'Experiencia CMS', 'en' => 'CMS Experience'],
            'paragraphs' => ['es' => ['Cuerpo CMS'], 'en' => ['CMS body']],
            'tag' => ['es' => 'Spa', 'en' => 'Spa'],
        ]);

        $items = cms('cigno-ermita-experiences')->ermitaExperiences();

        $this->assertCount(1, $items);
        $this->assertSame('Experiencia CMS', $items[0]['title']);
        $this->assertSame('Cuerpo CMS', $items[0]['body']);
        $this->assertSame('experience-gastro.mp4', $items[0]['video']);
    }

    public function test_mejorada_experiences_use_database_when_cms_on(): void
    {
        CmsPage::query()->where('slug', 'cigno-mejorada-experiences')->update(['cms_enabled' => true]);

        MejoradaExperience::query()->create([
            'slug' => 'mej-exp-cms',
            'sort_order' => 1,
            'is_published' => true,
            'image' => 'images/home/ermita.png',
            'title' => ['es' => 'Mejorada CMS', 'en' => 'Mejorada CMS EN'],
            'paragraphs' => ['es' => ['Texto Mejorada'], 'en' => ['Mejorada text']],
        ]);

        $items = cms('cigno-mejorada-experiences')->mejoradaExperiences();

        $this->assertCount(1, $items);
        $this->assertSame('Mejorada CMS', $items[0]['title']);
    }

    public function test_offers_repeater_overrides_lang_when_cms_on(): void
    {
        CmsPage::query()->where('slug', 'cigno-ermita-offers')->update([
            'cms_enabled' => true,
            'content' => [
                'es' => [
                    'offers' => [
                        'items' => [
                            [
                                'image' => 'images/ermita/offers/offer-2.png',
                                'title' => 'Oferta CMS',
                                'dates' => 'Solo esta semana',
                                'perks' => "Cóctel\nDesayuno",
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $offers = cms('cigno-ermita-offers')->offers('ermita.offers_section.items');

        $this->assertCount(1, $offers);
        $this->assertSame('Oferta CMS', $offers[0]['title']);
        $this->assertSame(['Cóctel', 'Desayuno'], $offers[0]['perks']);
    }

    public function test_venue_spaces_fallback_to_lang(): void
    {
        $spaces = cms('cigno-ermita-venue')->venueSpaces('ermita.venue.spaces');

        $this->assertNotEmpty($spaces);
        $this->assertSame(trans('ermita.venue.spaces.0.title'), $spaces[0]['title']);
    }

    public function test_experience_seeders_populate_rows(): void
    {
        $this->seed(ErmitaExperienceSeeder::class);
        $this->seed(MejoradaExperienceSeeder::class);

        $this->assertGreaterThan(0, ErmitaExperience::query()->count());
        $this->assertGreaterThan(0, MejoradaExperience::query()->count());
    }
}
