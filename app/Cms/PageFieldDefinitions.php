<?php

namespace App\Cms;

use App\Enums\CmsPageSlug;

class PageFieldDefinitions
{
    /**
     * @return list<array{section: string, fields: list<array<string, mixed>>}>
     */
    public static function sections(CmsPageSlug $slug): array
    {
        return match ($slug) {
            CmsPageSlug::Home => self::homeSections(),
            CmsPageSlug::Contact => self::contactSections(),
            CmsPageSlug::Club => self::clubSections(),
            CmsPageSlug::Press => self::pressSections(),
            CmsPageSlug::Shop => self::shopSections(),
            CmsPageSlug::Cocina => self::cocinaSections(),
            CmsPageSlug::Ermita => self::ermitaHomeSections(),
            CmsPageSlug::ErmitaRooms => self::ermitaRoomsSections(),
            CmsPageSlug::ErmitaRestaurant => self::ermitaRestaurantSections(),
            CmsPageSlug::ErmitaDaypass => self::ermitaDaypassSections(),
            CmsPageSlug::ErmitaExperiences => self::ermitaExperiencesSections(),
            CmsPageSlug::ErmitaVenue => self::ermitaVenueSections(),
            CmsPageSlug::ErmitaContact => self::ermitaContactSections(),
            CmsPageSlug::Mejorada => self::mejoradaHomeSections(),
            CmsPageSlug::MejoradaBarrio => self::mejoradaBarrioSections(),
            CmsPageSlug::MejoradaOffers => self::mejoradaOffersSections(),
            CmsPageSlug::MejoradaRooms => self::mejoradaRoomsSections(),
            CmsPageSlug::MejoradaRestaurant => self::mejoradaRestaurantSections(),
            CmsPageSlug::MejoradaDaypass => self::mejoradaDaypassSections(),
            CmsPageSlug::MejoradaExperiences => self::mejoradaExperiencesSections(),
            CmsPageSlug::MejoradaVenue => self::mejoradaVenueSections(),
            CmsPageSlug::MejoradaContact => self::mejoradaContactSections(),
            CmsPageSlug::LegalNotice, CmsPageSlug::CookiesPolicy, CmsPageSlug::CookieSettings => self::legalSections($slug),
        };
    }

    /**
     * @return list<array{section: string, fields: list<array<string, mixed>>}>
     */
    private static function homeSections(): array
    {
        return [
            [
                'section' => 'Hero',
                'fields' => [
                    ['key' => 'hero.background', 'label' => 'Póster / imagen de fondo', 'type' => 'image', 'fallback' => 'images/home/Home (1).png', 'media' => true],
                    ['key' => 'hero.video', 'label' => 'Video de fondo', 'type' => 'video', 'fallback' => 'videos/01. WEB Cignos (1).mp4', 'media' => true],
                ],
            ],
            [
                'section' => 'Historia',
                'fields' => [
                    ['key' => 'story.title', 'label' => 'Título (accesibilidad)', 'type' => 'text', 'fallback' => 'home.story.title'],
                    ['key' => 'story.lead_1', 'label' => 'Texto imagen derecha', 'type' => 'textarea', 'fallback' => 'home.story.lead_1'],
                    ['key' => 'story.lead_2', 'label' => 'Texto imagen izquierda', 'type' => 'textarea', 'fallback' => 'home.story.lead_2'],
                    ['key' => 'story.image_1', 'label' => 'Imagen izquierda', 'type' => 'image', 'fallback' => 'images/mejorada/home/story-2.png', 'media' => true],
                    ['key' => 'story.image_2', 'label' => 'Imagen derecha', 'type' => 'image', 'fallback' => 'images/home/seccion1.2.png', 'media' => true],
                ],
            ],
            [
                'section' => 'Destino',
                'fields' => [
                    ['key' => 'destination.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'home.destination.title'],
                    ['key' => 'destination.lead_1', 'label' => 'Párrafo 1', 'type' => 'textarea', 'fallback' => 'home.destination.lead_1'],
                    ['key' => 'destination.lead_2', 'label' => 'Párrafo 2', 'type' => 'textarea', 'fallback' => 'home.destination.lead_2'],
                    ['key' => 'destination.icon', 'label' => 'Icono', 'type' => 'image', 'fallback' => 'images/home/Vector (15).svg', 'media' => true],
                    ['key' => 'destination.image', 'label' => 'Póster / imagen', 'type' => 'image', 'fallback' => 'images/home/destinos.png', 'media' => true],
                    ['key' => 'destination.video', 'label' => 'Video', 'type' => 'video', 'fallback' => 'videos/Copia de Reel 02 Barrio de La Mejorada.mp4', 'media' => true],
                ],
            ],
            [
                'section' => 'Hoteles',
                'fields' => [
                    ['key' => 'hotels.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'home.hotels.title'],
                    ['key' => 'hotels.ermita_background', 'label' => 'Fondo Ermita', 'type' => 'image', 'fallback' => 'images/home/Ermitaback.png', 'media' => true],
                    ['key' => 'hotels.mejorada_background', 'label' => 'Fondo Mejorada', 'type' => 'image', 'fallback' => 'images/home/mejoradaback.png', 'media' => true],
                    ['key' => 'hotels.ermita_video', 'label' => 'Video Ermita (hover)', 'type' => 'video', 'fallback' => 'videos/padel.mp4', 'media' => true],
                    ['key' => 'hotels.mejorada_video', 'label' => 'Video Mejorada (hover)', 'type' => 'video', 'fallback' => 'videos/agua.mp4', 'media' => true],
                    ['key' => 'hotels.ermita_logo', 'label' => 'Logo Ermita', 'type' => 'image', 'fallback' => 'images/home/Logotipo.svg', 'media' => true],
                    ['key' => 'hotels.mejorada_logo', 'label' => 'Logo Mejorada', 'type' => 'image', 'fallback' => 'images/home/mejorada.svg', 'media' => true],
                ],
            ],
            [
                'section' => 'Cigno Club (teaser)',
                'fields' => [
                    ['key' => 'club.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'home.club.title'],
                    ['key' => 'club.line_1', 'label' => 'Línea 1', 'type' => 'text', 'fallback' => 'home.club.line_1'],
                    ['key' => 'club.line_2', 'label' => 'Línea 2', 'type' => 'text', 'fallback' => 'home.club.line_2'],
                    ['key' => 'club.discount_title', 'label' => 'Descuento — título', 'type' => 'text', 'fallback' => 'home.club.discount_title'],
                    ['key' => 'club.discount_body', 'label' => 'Descuento — texto', 'type' => 'textarea', 'fallback' => 'home.club.discount_body'],
                    ['key' => 'club.gifts_title', 'label' => 'Regalos — título', 'type' => 'text', 'fallback' => 'home.club.gifts_title'],
                    ['key' => 'club.gifts_body', 'label' => 'Regalos — texto', 'type' => 'textarea', 'fallback' => 'home.club.gifts_body'],
                    ['key' => 'club.vip_title', 'label' => 'VIP — título', 'type' => 'text', 'fallback' => 'home.club.vip_title'],
                    ['key' => 'club.vip_body', 'label' => 'VIP — texto', 'type' => 'textarea', 'fallback' => 'home.club.vip_body'],
                    ['key' => 'club.vip_note', 'label' => 'Nota (label)', 'type' => 'text', 'fallback' => 'home.club.vip_note'],
                    ['key' => 'club.background', 'label' => 'Fondo', 'type' => 'image', 'fallback' => 'images/home/Cigno Club (1).png', 'media' => true],
                ],
            ],
            [
                'section' => 'Experiencias',
                'fields' => [
                    ['key' => 'experiences.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'home.experiences.title'],
                    ['key' => 'experiences.lead_1', 'label' => 'Párrafo 1', 'type' => 'textarea', 'fallback' => 'home.experiences.lead_1'],
                    ['key' => 'experiences.lead_2', 'label' => 'Párrafo 2', 'type' => 'textarea', 'fallback' => 'home.experiences.lead_2'],
                    ['key' => 'experiences.icon', 'label' => 'Icono', 'type' => 'image', 'fallback' => 'images/home/experiences-icon.png', 'media' => true],
                ],
            ],
            [
                'section' => 'Cocina Vidente',
                'fields' => [
                    ['key' => 'cocina.body', 'label' => 'Texto', 'type' => 'textarea', 'fallback' => 'home.cocina.body'],
                    ['key' => 'cocina.book_ermita', 'label' => 'CTA Ermita', 'type' => 'text', 'fallback' => 'home.cocina.book_ermita'],
                    ['key' => 'cocina.book_mejorada', 'label' => 'CTA Mejorada', 'type' => 'text', 'fallback' => 'home.cocina.book_mejorada'],
                    ['key' => 'cocina.see_more', 'label' => 'CTA ver más', 'type' => 'text', 'fallback' => 'home.cocina.see_more'],
                    ['key' => 'cocina.logo', 'label' => 'Logo', 'type' => 'image', 'fallback' => 'images/home/Cocina Vidente.svg', 'media' => true],
                    ['key' => 'cocina.background', 'label' => 'Fondo', 'type' => 'image', 'fallback' => 'images/home/About (1).png', 'media' => true],
                    ['key' => 'cocina.video', 'label' => 'Video (media)', 'type' => 'video', 'fallback' => 'videos/Cocina.mp4', 'media' => true],
                    ['key' => 'cocina.poster', 'label' => 'Póster del video', 'type' => 'image', 'fallback' => 'images/cocina/gallery-meat.png', 'media' => true],
                    [
                        'key' => 'cocina.gallery',
                        'label' => 'Galería',
                        'type' => 'gallery',
                        'fallback' => 'images/cocina/gallery-meat.png, images/cocina/gallery-mole.png, images/cocina/gallery-carpaccio.png',
                        'media' => true,
                    ],
                ],
            ],
            [
                'section' => 'Tiendita (teaser)',
                'fields' => [
                    ['key' => 'tiendita.tagline', 'label' => 'Tagline', 'type' => 'text', 'fallback' => 'home.tiendita.tagline'],
                    ['key' => 'tiendita.body', 'label' => 'Texto', 'type' => 'textarea', 'fallback' => 'home.tiendita.body'],
                    ['key' => 'tiendita.cta', 'label' => 'CTA', 'type' => 'text', 'fallback' => 'home.tiendita.cta'],
                    ['key' => 'tiendita.background', 'label' => 'Fondo', 'type' => 'image', 'fallback' => 'images/home/Experience Collection.png', 'media' => true],
                ],
            ],
            [
                'section' => 'Prensa (teaser)',
                'fields' => [
                    ['key' => 'press.tagline', 'label' => 'Tagline', 'type' => 'text', 'fallback' => 'home.press.tagline'],
                    ['key' => 'press.body', 'label' => 'Texto', 'type' => 'textarea', 'fallback' => 'home.press.body'],
                    ['key' => 'press.cta', 'label' => 'CTA', 'type' => 'text', 'fallback' => 'home.press.cta'],
                    ['key' => 'press.background', 'label' => 'Fondo', 'type' => 'image', 'fallback' => 'images/home/Cigno Club.png', 'media' => true],
                ],
            ],
        ];
    }

    /**
     * @return list<array{section: string, fields: list<array<string, mixed>>}>
     */
    private static function contactSections(): array
    {
        return [
            [
                'section' => 'Contenido',
                'fields' => [
                    ['key' => 'lead_1', 'label' => 'Párrafo 1', 'type' => 'textarea', 'fallback' => 'contact.lead_1'],
                    ['key' => 'lead_2', 'label' => 'Párrafo 2', 'type' => 'textarea', 'fallback' => 'contact.lead_2'],
                    ['key' => 'logo', 'label' => 'Icono', 'type' => 'image', 'fallback' => 'images/footer/Swan.svg', 'media' => true],
                ],
            ],
        ];
    }

    /**
     * @return list<array{section: string, fields: list<array<string, mixed>>}>
     */
    private static function clubSections(): array
    {
        return [
            [
                'section' => 'Contenido',
                'fields' => [
                    ['key' => 'lead', 'label' => 'Intro', 'type' => 'textarea', 'fallback' => 'club.lead'],
                    ['key' => 'prompt', 'label' => 'Prompt', 'type' => 'text', 'fallback' => 'club.prompt'],
                    ['key' => 'sign_up_url', 'label' => 'URL Registrarse', 'type' => 'text'],
                    ['key' => 'sign_in_url', 'label' => 'URL Iniciar sesión', 'type' => 'text'],
                    ['key' => 'logo', 'label' => 'Icono', 'type' => 'image', 'fallback' => 'images/club/Guia.svg', 'media' => true],
                ],
            ],
        ];
    }

    /**
     * @return list<array{section: string, fields: list<array<string, mixed>>}>
     */
    private static function pressSections(): array
    {
        return [
            [
                'section' => 'Página',
                'fields' => [
                    ['key' => 'intro', 'label' => 'Intro', 'type' => 'textarea', 'fallback' => 'press.intro'],
                    ['key' => 'logo', 'label' => 'Icono', 'type' => 'image', 'fallback' => 'images/home/Union (3)2.svg', 'media' => true],
                ],
            ],
        ];
    }

    /**
     * @return list<array{section: string, fields: list<array<string, mixed>>}>
     */
    private static function shopSections(): array
    {
        return [
            [
                'section' => 'Página',
                'fields' => [
                    ['key' => 'title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'shop.title'],
                    ['key' => 'lead_1', 'label' => 'Párrafo 1', 'type' => 'textarea', 'fallback' => 'shop.lead_1'],
                    ['key' => 'lead_2', 'label' => 'Párrafo 2', 'type' => 'textarea', 'fallback' => 'shop.lead_2'],
                    ['key' => 'logo', 'label' => 'Icono', 'type' => 'image', 'fallback' => 'images/home/Isolation_Mode (6).svg', 'media' => true],
                ],
            ],
        ];
    }

    /**
     * @return list<array{section: string, fields: list<array<string, mixed>>}>
     */
    private static function cocinaSections(): array
    {
        return [
            [
                'section' => 'Hero',
                'fields' => [
                    ['key' => 'title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'cocina.title'],
                    ['key' => 'lead', 'label' => 'Intro', 'type' => 'textarea', 'fallback' => 'cocina.lead'],
                    ['key' => 'book_ermita', 'label' => 'CTA Ermita', 'type' => 'text', 'fallback' => 'cocina.book_ermita'],
                    ['key' => 'book_mejorada', 'label' => 'CTA Mejorada', 'type' => 'text', 'fallback' => 'cocina.book_mejorada'],
                    ['key' => 'see_menu', 'label' => 'CTA menú', 'type' => 'text', 'fallback' => 'cocina.see_menu'],
                    ['key' => 'menu_url', 'label' => 'URL menú', 'type' => 'text', 'fallback' => 'cocina.menu_url'],
                    ['key' => 'hero_image_alt', 'label' => 'Alt video / imagen hero', 'type' => 'text', 'fallback' => 'cocina.hero_image_alt'],
                    ['key' => 'logo', 'label' => 'Logo', 'type' => 'image', 'fallback' => 'images/home/Cocina Vidente.svg', 'media' => true],
                    ['key' => 'hero_image', 'label' => 'Póster hero', 'type' => 'image', 'fallback' => 'images/cocina/766674731_1038934385408593_3915687115600101391_n.jpg', 'media' => true],
                    ['key' => 'hero_video', 'label' => 'Video hero', 'type' => 'video', 'fallback' => 'videos/restaurante.mp4', 'media' => true],
                ],
            ],
            [
                'section' => 'Chef',
                'fields' => [
                    ['key' => 'chef.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'cocina.chef.title'],
                    ['key' => 'chef.body_1', 'label' => 'Párrafo 1', 'type' => 'textarea', 'fallback' => 'cocina.chef.body_1'],
                    ['key' => 'chef.body_2', 'label' => 'Párrafo 2', 'type' => 'textarea', 'fallback' => 'cocina.chef.body_2'],
                    ['key' => 'chef.image_alt', 'label' => 'Alt foto chef', 'type' => 'text', 'fallback' => 'cocina.chef.image_alt'],
                    ['key' => 'chef.icon', 'label' => 'Icono', 'type' => 'image', 'fallback' => 'images/cocina/isotipo.png', 'media' => true],
                    ['key' => 'chef.image', 'label' => 'Foto chef', 'type' => 'image', 'fallback' => 'images/ermita/restaurant/Rectangle 4 (6).png', 'media' => true],
                ],
            ],
        ];
    }

    /**
     * @return list<array{section: string, fields: list<array<string, mixed>>}>
     */
    private static function ermitaHomeSections(): array
    {
        return [
            [
                'section' => 'Hero',
                'fields' => [
                    ['key' => 'hero.background', 'label' => 'Póster / imagen de fondo', 'type' => 'image', 'fallback' => 'images/ermita/home/banner.png', 'media' => true],
                    ['key' => 'hero.video', 'label' => 'Video de fondo', 'type' => 'video', 'fallback' => 'videos/02. Video ERMITA Web Cignos (1).mp4', 'media' => true],
                ],
            ],
            [
                'section' => 'Historia',
                'fields' => [
                    ['key' => 'story.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'ermita.story.title'],
                    ['key' => 'story.lead_1', 'label' => 'Párrafo 1', 'type' => 'textarea', 'fallback' => 'ermita.story.lead_1'],
                    ['key' => 'story.lead_2', 'label' => 'Párrafo 2', 'type' => 'textarea', 'fallback' => 'ermita.story.lead_2'],
                    [
                        'key' => 'story.gallery',
                        'label' => 'Galería',
                        'type' => 'gallery',
                        'fallback' => 'images/home/ermita.png, images/home/Rectangle 4.jpg, images/home/Rectangle 2 (5).png',
                        'media' => true,
                    ],
                ],
            ],
            [
                'section' => 'Habitaciones (teaser)',
                'fields' => [
                    ['key' => 'rooms.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'ermita.rooms.title'],
                    ['key' => 'rooms.lead_1', 'label' => 'Párrafo 1', 'type' => 'textarea', 'fallback' => 'ermita.rooms.lead_1'],
                    ['key' => 'rooms.lead_2', 'label' => 'Párrafo 2', 'type' => 'textarea', 'fallback' => 'ermita.rooms.lead_2'],
                    ['key' => 'rooms.cta', 'label' => 'CTA', 'type' => 'text', 'fallback' => 'ermita.rooms.cta'],
                ],
            ],
            [
                'section' => 'Amenities',
                'fields' => [
                    ['key' => 'amenities.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'ermita.amenities.title'],
                    ['key' => 'amenities.lead', 'label' => 'Intro', 'type' => 'textarea', 'fallback' => 'ermita.amenities.lead'],
                ],
            ],
            [
                'section' => 'Cocina Vidente (teaser)',
                'fields' => [
                    ['key' => 'cocina.body', 'label' => 'Texto', 'type' => 'textarea', 'fallback' => 'ermita.cocina.body'],
                    ['key' => 'cocina.book', 'label' => 'Reservar', 'type' => 'text', 'fallback' => 'ermita.cocina.book'],
                    ['key' => 'cocina.see_more', 'label' => 'Ver más', 'type' => 'text', 'fallback' => 'ermita.cocina.see_more'],
                    [
                        'key' => 'cocina.gallery',
                        'label' => 'Galería',
                        'type' => 'gallery',
                        'fallback' => 'images/cocina/…',
                        'media' => true,
                    ],
                ],
            ],
            [
                'section' => 'Experiencias (teaser)',
                'fields' => [
                    ['key' => 'experiences.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'ermita.experiences.title'],
                    ['key' => 'experiences.tagline', 'label' => 'Tagline', 'type' => 'text', 'fallback' => 'ermita.experiences.tagline'],
                    ['key' => 'experiences.body', 'label' => 'Texto', 'type' => 'textarea', 'fallback' => 'ermita.experiences.body'],
                    ['key' => 'experiences.cta', 'label' => 'CTA', 'type' => 'text', 'fallback' => 'ermita.experiences.cta'],
                ],
            ],
            [
                'section' => 'Daypass (teaser)',
                'fields' => [
                    ['key' => 'daypass.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'ermita.daypass.title'],
                    ['key' => 'daypass.schedule_days', 'label' => 'Días', 'type' => 'text', 'fallback' => 'ermita.daypass.schedule_days'],
                    ['key' => 'daypass.schedule_hours', 'label' => 'Horario', 'type' => 'text', 'fallback' => 'ermita.daypass.schedule_hours'],
                    ['key' => 'daypass.price', 'label' => 'Precio', 'type' => 'text', 'fallback' => 'ermita.daypass.price'],
                    ['key' => 'daypass.includes', 'label' => 'Incluye', 'type' => 'textarea', 'fallback' => 'ermita.daypass.includes'],
                    ['key' => 'daypass.restrictions', 'label' => 'Restricciones', 'type' => 'text', 'fallback' => 'ermita.daypass.restrictions'],
                    ['key' => 'daypass.cta_primary', 'label' => 'CTA principal', 'type' => 'text', 'fallback' => 'ermita.daypass.cta_primary'],
                    ['key' => 'daypass.cta_secondary', 'label' => 'CTA secundario', 'type' => 'text', 'fallback' => 'ermita.daypass.cta_secondary'],
                    ['key' => 'daypass.image', 'label' => 'Imagen', 'type' => 'image', 'fallback' => 'images/home/ermita.png', 'media' => true],
                ],
            ],
            [
                'section' => 'Huéspedes',
                'fields' => [
                    ['key' => 'guests.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'ermita.guests.title'],
                    ['key' => 'guests.lead', 'label' => 'Intro', 'type' => 'textarea', 'fallback' => 'ermita.guests.lead'],
                ],
            ],
            [
                'section' => 'Ubicación',
                'fields' => [
                    ['key' => 'location.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'ermita.location.title'],
                    ['key' => 'location.body', 'label' => 'Texto', 'type' => 'textarea', 'fallback' => 'ermita.location.body'],
                    ['key' => 'location.cta', 'label' => 'CTA', 'type' => 'text', 'fallback' => 'ermita.location.cta'],
                    ['key' => 'location.map_url', 'label' => 'URL del mapa', 'type' => 'text', 'fallback' => 'ermita.location.map_url'],
                ],
            ],
        ];
    }

    /**
     * @return list<array{section: string, fields: list<array<string, mixed>>}>
     */
    private static function ermitaRoomsSections(): array
    {
        return [
            [
                'section' => 'Página',
                'fields' => [
                    ['key' => 'rooms_page.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'ermita.rooms_page.title'],
                    ['key' => 'rooms_page.lead_1', 'label' => 'Párrafo 1', 'type' => 'textarea', 'fallback' => 'ermita.rooms_page.lead_1'],
                    ['key' => 'rooms_page.lead_2', 'label' => 'Párrafo 2', 'type' => 'textarea', 'fallback' => 'ermita.rooms_page.lead_2'],
                    ['key' => 'rooms_page.more_info', 'label' => 'Más información', 'type' => 'text', 'fallback' => 'ermita.rooms_page.more_info'],
                    ['key' => 'rooms_page.reserve', 'label' => 'Reservar', 'type' => 'text', 'fallback' => 'ermita.rooms_page.reserve'],
                    ['key' => 'rooms_page.offers_title', 'label' => 'Título ofertas', 'type' => 'text', 'fallback' => 'ermita.rooms_page.offers_title'],
                    ['key' => 'rooms_page.shared_amenities_note', 'label' => 'Nota amenities compartidos', 'type' => 'textarea', 'fallback' => 'ermita.rooms_page.all_rooms'],
                ],
            ],
        ];
    }

    /**
     * @return list<array{section: string, fields: list<array<string, mixed>>}>
     */
    private static function ermitaRestaurantSections(): array
    {
        return [
            [
                'section' => 'Página',
                'fields' => [
                    ['key' => 'restaurant.page_title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'ermita.restaurant.page_title'],
                    ['key' => 'restaurant.lead', 'label' => 'Intro', 'type' => 'textarea', 'fallback' => 'ermita.restaurant.lead'],
                    ['key' => 'restaurant.book', 'label' => 'Reservar', 'type' => 'text', 'fallback' => 'ermita.restaurant.book'],
                    ['key' => 'restaurant.see_menu', 'label' => 'Ver menú', 'type' => 'text', 'fallback' => 'ermita.restaurant.see_menu'],
                    ['key' => 'restaurant.menu_url', 'label' => 'URL del menú', 'type' => 'text', 'fallback' => 'ermita.restaurant.menu_url'],
                    ['key' => 'restaurant.gallery_alt', 'label' => 'Alt video / galería', 'type' => 'text', 'fallback' => 'ermita.restaurant.gallery_alt'],
                    ['key' => 'restaurant.logo', 'label' => 'Logo', 'type' => 'image', 'fallback' => 'images/home/Cocina Vidente.svg', 'media' => true],
                    ['key' => 'restaurant.hero_poster', 'label' => 'Póster video', 'type' => 'image', 'fallback' => 'images/ermita/home/restaurante.png', 'media' => true],
                    ['key' => 'restaurant.hero_video', 'label' => 'Video hero', 'type' => 'video', 'fallback' => 'videos/restaurante.mp4', 'media' => true],
                    [
                        'key' => 'restaurant.gallery',
                        'label' => 'Galería',
                        'type' => 'gallery',
                        'fallback' => 'images/cocina/gallery-meat.png',
                        'media' => true,
                    ],
                ],
            ],
            [
                'section' => 'Signature Moments',
                'fields' => [
                    ['key' => 'restaurant.signature.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'ermita.restaurant.signature.title'],
                    ['key' => 'restaurant.signature.breakfast.title', 'label' => 'Desayuno — título', 'type' => 'text', 'fallback' => 'ermita.restaurant.signature.breakfast.title'],
                    ['key' => 'restaurant.signature.breakfast.hours', 'label' => 'Desayuno — horario', 'type' => 'text', 'fallback' => 'ermita.restaurant.signature.breakfast.hours'],
                    ['key' => 'restaurant.signature.breakfast.body', 'label' => 'Desayuno — texto', 'type' => 'textarea', 'fallback' => 'ermita.restaurant.signature.breakfast.body'],
                    ['key' => 'restaurant.signature.dinner.title', 'label' => 'Cena — título', 'type' => 'text', 'fallback' => 'ermita.restaurant.signature.dinner.title'],
                    ['key' => 'restaurant.signature.dinner.body', 'label' => 'Cena — texto', 'type' => 'textarea', 'fallback' => 'ermita.restaurant.signature.dinner.body'],
                    ['key' => 'restaurant.signature.note', 'label' => 'Nota', 'type' => 'textarea', 'fallback' => 'ermita.restaurant.signature.note'],
                    ['key' => 'restaurant.signature.icon', 'label' => 'Icono', 'type' => 'image', 'fallback' => 'images/home/Cocina Vidente.svg', 'media' => true],
                ],
            ],
            [
                'section' => 'Chef',
                'fields' => [
                    ['key' => 'restaurant.chef.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'ermita.restaurant.chef.title'],
                    ['key' => 'restaurant.chef.body_1', 'label' => 'Párrafo 1', 'type' => 'textarea', 'fallback' => 'ermita.restaurant.chef.body_1'],
                    ['key' => 'restaurant.chef.body_2', 'label' => 'Párrafo 2', 'type' => 'textarea', 'fallback' => 'ermita.restaurant.chef.body_2'],
                    ['key' => 'restaurant.chef.image', 'label' => 'Foto del chef', 'type' => 'image', 'fallback' => 'images/home/ermita.png', 'media' => true],
                ],
            ],
        ];
    }

    /**
     * @return list<array{section: string, fields: list<array<string, mixed>>}>
     */
    private static function ermitaDaypassSections(): array
    {
        return [
            [
                'section' => 'Página',
                'fields' => [
                    ['key' => 'daypass.page_title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'ermita.daypass.page_title'],
                    ['key' => 'daypass.schedule_days', 'label' => 'Días', 'type' => 'text', 'fallback' => 'ermita.daypass.schedule_days'],
                    ['key' => 'daypass.schedule_hours', 'label' => 'Horario', 'type' => 'text', 'fallback' => 'ermita.daypass.schedule_hours'],
                    ['key' => 'daypass.price', 'label' => 'Precio', 'type' => 'text', 'fallback' => 'ermita.daypass.price'],
                    ['key' => 'daypass.includes', 'label' => 'Incluye', 'type' => 'textarea', 'fallback' => 'ermita.daypass.includes'],
                    ['key' => 'daypass.restrictions', 'label' => 'Restricciones', 'type' => 'text', 'fallback' => 'ermita.daypass.restrictions'],
                    ['key' => 'daypass.page_cta', 'label' => 'CTA', 'type' => 'text', 'fallback' => 'ermita.daypass.page_cta'],
                    [
                        'key' => 'daypass.gallery',
                        'label' => 'Galería',
                        'type' => 'gallery',
                        'fallback' => 'images/cocina/…, images/home/ermita.png',
                        'media' => true,
                    ],
                    ['key' => 'daypass.mark', 'label' => 'Icono / marca', 'type' => 'image', 'fallback' => 'images/home/Union (3).svg', 'media' => true],
                ],
            ],
            [
                'section' => 'Amenities',
                'fields' => [
                    ['key' => 'daypass.amenities.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'ermita.daypass.amenities.title'],
                    ['key' => 'daypass.amenities.lead', 'label' => 'Intro', 'type' => 'textarea', 'fallback' => 'ermita.daypass.amenities.lead'],
                ],
            ],
        ];
    }

    /**
     * @return list<array{section: string, fields: list<array<string, mixed>>}>
     */
    private static function ermitaExperiencesSections(): array
    {
        return [
            [
                'section' => 'Página',
                'fields' => [
                    ['key' => 'experiences_page.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'ermita.experiences_page.title'],
                    ['key' => 'experiences_page.lead', 'label' => 'Lead', 'type' => 'textarea', 'fallback' => 'ermita.experiences_page.lead'],
                    ['key' => 'experiences_page.intro', 'label' => 'Intro', 'type' => 'textarea', 'fallback' => 'ermita.experiences_page.intro'],
                ],
            ],
        ];
    }

    /**
     * @return list<array{section: string, fields: list<array<string, mixed>>}>
     */
    private static function ermitaVenueSections(): array
    {
        return [
            [
                'section' => 'Página',
                'fields' => [
                    ['key' => 'venue.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'ermita.venue.title'],
                    ['key' => 'venue.lead', 'label' => 'Lead', 'type' => 'textarea', 'fallback' => 'ermita.venue.lead'],
                    ['key' => 'venue.intro', 'label' => 'Intro', 'type' => 'textarea', 'fallback' => 'ermita.venue.intro'],
                    ['key' => 'venue.form_lead', 'label' => 'Lead del formulario', 'type' => 'textarea', 'fallback' => 'ermita.venue.form_lead'],
                    [
                        'key' => 'venue.gallery',
                        'label' => 'Galería',
                        'type' => 'gallery',
                        'fallback' => 'images/cocina/…, images/home/ermita.png',
                        'media' => true,
                    ],
                ],
            ],
        ];
    }

    /**
     * @return list<array{section: string, fields: list<array<string, mixed>>}>
     */
    private static function ermitaContactSections(): array
    {
        return [
            [
                'section' => 'Contenido',
                'fields' => [
                    ['key' => 'contact.lead_1', 'label' => 'Párrafo 1', 'type' => 'textarea', 'fallback' => 'ermita.contact.lead_1'],
                    ['key' => 'contact.lead_2', 'label' => 'Párrafo 2', 'type' => 'textarea', 'fallback' => 'ermita.contact.lead_2'],
                    ['key' => 'contact.logo', 'label' => 'Logo', 'type' => 'image', 'fallback' => 'images/footer/Swan.svg', 'media' => true],
                ],
            ],
        ];
    }

    /**
     * @return list<array{section: string, fields: list<array<string, mixed>>}>
     */
    private static function mejoradaHomeSections(): array
    {
        return [
            [
                'section' => 'Hero',
                'fields' => [
                    ['key' => 'hero.line_1', 'label' => 'Línea 1', 'type' => 'text', 'fallback' => 'mejorada.hero.line_1'],
                    ['key' => 'hero.line_2', 'label' => 'Línea 2', 'type' => 'text', 'fallback' => 'mejorada.hero.line_2'],
                    ['key' => 'hero.background', 'label' => 'Póster / imagen de fondo', 'type' => 'image', 'fallback' => 'images/home/Home (1).png', 'media' => true],
                    ['key' => 'hero.video', 'label' => 'Video de fondo', 'type' => 'video', 'fallback' => 'videos/03. Video MEJORADA Web Cignos.mp4', 'media' => true],
                    ['key' => 'hero.logo', 'label' => 'Logo cisne', 'type' => 'image', 'fallback' => 'images/home/Swan (1).svg', 'media' => true],
                ],
            ],
            [
                'section' => 'Historia',
                'fields' => [
                    ['key' => 'story.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.story.title'],
                    ['key' => 'story.lead_1', 'label' => 'Párrafo 1 (Michelin)', 'type' => 'textarea', 'fallback' => 'mejorada.story.lead_1'],
                    ['key' => 'story.lead_2', 'label' => 'Párrafo 2', 'type' => 'textarea', 'fallback' => 'mejorada.story.lead_2'],
                    ['key' => 'story.book_btn', 'label' => 'Texto botón reserva', 'type' => 'text', 'fallback' => 'mejorada.story.book_btn'],
                    ['key' => 'story.discover_btn', 'label' => 'Texto botón descubrir', 'type' => 'text', 'fallback' => 'mejorada.story.discover_btn'],
                    [
                        'key' => 'story.gallery',
                        'label' => 'Galería (2 imágenes)',
                        'type' => 'gallery',
                        'fallback' => 'images/mejorada/home/story-2.png, images/mejorada/home/story-1.png',
                        'media' => true,
                    ],
                ],
            ],
            [
                'section' => 'Barrio La Mejorada',
                'fields' => [
                    ['key' => 'barrio.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.story.barrio_title'],
                    ['key' => 'barrio.lead', 'label' => 'Texto', 'type' => 'textarea', 'fallback' => 'mejorada.story.barrio_lead'],
                    ['key' => 'barrio.cta', 'label' => 'Texto botón', 'type' => 'text', 'fallback' => 'mejorada.story.barrio_cta'],
                    ['key' => 'barrio.image', 'label' => 'Imagen / Poster video', 'type' => 'image', 'fallback' => 'images/mejorada/barrio-window.jpg', 'media' => true],
                ],
            ],
            [
                'section' => 'Habitaciones',
                'fields' => [
                    ['key' => 'rooms.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.rooms.title'],
                    ['key' => 'rooms.lead_1', 'label' => 'Párrafo 1', 'type' => 'textarea', 'fallback' => 'mejorada.rooms.lead_1'],
                    ['key' => 'rooms.lead_2', 'label' => 'Párrafo 2', 'type' => 'textarea', 'fallback' => 'mejorada.rooms.lead_2'],
                    ['key' => 'rooms.cta', 'label' => 'Texto botón', 'type' => 'text', 'fallback' => 'mejorada.rooms.cta'],
                ],
            ],
            [
                'section' => 'Amenities',
                'fields' => [
                    ['key' => 'amenities.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.amenities.title'],
                    ['key' => 'amenities.lead', 'label' => 'Bajada', 'type' => 'text', 'fallback' => 'mejorada.amenities.lead'],
                ],
            ],
            [
                'section' => 'Cocina Vidente',
                'fields' => [
                    ['key' => 'cocina.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.cocina.title'],
                    ['key' => 'cocina.body', 'label' => 'Filosofía / Párrafo', 'type' => 'textarea', 'fallback' => 'mejorada.cocina.body'],
                    ['key' => 'cocina.book', 'label' => 'Botón reserva mesa', 'type' => 'text', 'fallback' => 'mejorada.cocina.book'],
                    ['key' => 'cocina.see_more', 'label' => 'Botón ver más', 'type' => 'text', 'fallback' => 'mejorada.cocina.see_more'],
                    [
                        'key' => 'cocina.gallery',
                        'label' => 'Galería',
                        'type' => 'gallery',
                        'fallback' => 'images/cocina/gallery-meat.png, images/cocina/gallery-mole.png',
                        'media' => true,
                    ],
                ],
            ],
            [
                'section' => 'Experiencias',
                'fields' => [
                    ['key' => 'experiences.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.experiences.title'],
                    ['key' => 'experiences.tagline', 'label' => 'Subtítulo', 'type' => 'text', 'fallback' => 'mejorada.experiences.tagline'],
                    ['key' => 'experiences.body', 'label' => 'Párrafo', 'type' => 'textarea', 'fallback' => 'mejorada.experiences.body'],
                    ['key' => 'experiences.cta', 'label' => 'Texto botón', 'type' => 'text', 'fallback' => 'mejorada.experiences.cta'],
                    ['key' => 'experiences.icon', 'label' => 'Icono', 'type' => 'image', 'fallback' => 'images/ermita/icons/Isolation_Mode (7).svg', 'media' => true],
                ],
            ],
            [
                'section' => 'Ofertas',
                'fields' => [
                    ['key' => 'offers.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.rooms_page.home_offers_title'],
                    ['key' => 'offers.lead', 'label' => 'Texto', 'type' => 'textarea', 'fallback' => 'mejorada.rooms_page.home_offers_lead'],
                    ['key' => 'offers.cta', 'label' => 'Texto botón', 'type' => 'text', 'fallback' => 'mejorada.rooms_page.home_offers_cta'],
                    ['key' => 'offers.background', 'label' => 'Imagen de fondo', 'type' => 'image', 'fallback' => 'images/mejorada/home/celebrate.jpg', 'media' => true],
                ],
            ],
            [
                'section' => 'Celebrate at Mejorada',
                'fields' => [
                    ['key' => 'venue_teaser.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.story.venue_title'],
                    ['key' => 'venue_teaser.lead', 'label' => 'Texto', 'type' => 'textarea', 'fallback' => 'mejorada.story.venue_lead'],
                    ['key' => 'venue_teaser.cta', 'label' => 'Texto botón', 'type' => 'text', 'fallback' => 'mejorada.story.venue_cta'],
                    ['key' => 'venue_teaser.image', 'label' => 'Imagen', 'type' => 'image', 'fallback' => 'images/mejorada/home/offers-bg.png', 'media' => true],
                ],
            ],
            [
                'section' => 'Daypass',
                'fields' => [
                    ['key' => 'daypass.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.daypass.title'],
                    ['key' => 'daypass.schedule_days', 'label' => 'Días', 'type' => 'text', 'fallback' => 'mejorada.daypass.schedule_days'],
                    ['key' => 'daypass.schedule_hours', 'label' => 'Horario', 'type' => 'text', 'fallback' => 'mejorada.daypass.schedule_hours'],
                    ['key' => 'daypass.price', 'label' => 'Precio', 'type' => 'text', 'fallback' => 'mejorada.daypass.price'],
                    ['key' => 'daypass.includes', 'label' => 'Incluye', 'type' => 'textarea', 'fallback' => 'mejorada.daypass.includes'],
                    ['key' => 'daypass.restrictions', 'label' => 'Restricciones', 'type' => 'text', 'fallback' => 'mejorada.daypass.restrictions'],
                    ['key' => 'daypass.cta_primary', 'label' => 'CTA principal', 'type' => 'text', 'fallback' => 'mejorada.daypass.cta_primary'],
                    ['key' => 'daypass.cta_secondary', 'label' => 'CTA secundario', 'type' => 'text', 'fallback' => 'mejorada.daypass.cta_secondary'],
                    ['key' => 'daypass.image', 'label' => 'Imagen', 'type' => 'image', 'fallback' => 'images/mejorada/daypass-hat.jpg', 'media' => true],
                ],
            ],
            [
                'section' => 'Huéspedes',
                'fields' => [
                    ['key' => 'guests.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.guests.title'],
                    ['key' => 'guests.lead', 'label' => 'Intro', 'type' => 'textarea', 'fallback' => 'mejorada.guests.lead'],
                ],
            ],
            [
                'section' => 'Ubicación',
                'fields' => [
                    ['key' => 'location.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.location.title'],
                    ['key' => 'location.body', 'label' => 'Texto', 'type' => 'textarea', 'fallback' => 'mejorada.location.body'],
                    ['key' => 'location.cta', 'label' => 'Texto botón', 'type' => 'text', 'fallback' => 'mejorada.location.cta'],
                    ['key' => 'location.map_url', 'label' => 'URL del mapa', 'type' => 'text', 'fallback' => 'mejorada.location.map_url'],
                    ['key' => 'location.map', 'label' => 'Mapa histórico', 'type' => 'image', 'fallback' => 'images/ermita/home/locations.png', 'media' => true],
                ],
            ],
        ];
    }

    /** @return list<array{section: string, fields: list<array<string, mixed>>}> */
    private static function mejoradaBarrioSections(): array
    {
        return [[
            'section' => 'Página',
            'fields' => [
                ['key' => 'barrio.page_title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.story.barrio_page_title'],
                ['key' => 'barrio.page_lead', 'label' => 'Introducción', 'type' => 'textarea', 'fallback' => 'mejorada.story.barrio_page_lead'],
                ['key' => 'barrio.banner_title', 'label' => 'Título histórico', 'type' => 'text', 'fallback' => 'mejorada.story.barrio_banner_title'],
                ['key' => 'barrio.banner_body', 'label' => 'Texto histórico', 'type' => 'textarea', 'fallback' => 'mejorada.story.barrio_banner_body'],
                ['key' => 'barrio.history_title', 'label' => 'Título patrimonio', 'type' => 'text', 'fallback' => 'mejorada.story.barrio_history_title'],
                ['key' => 'barrio.history_body', 'label' => 'Texto patrimonio', 'type' => 'textarea', 'fallback' => 'mejorada.story.barrio_history_body'],
            ],
        ]];
    }

    /** @return list<array{section: string, fields: list<array<string, mixed>>}> */
    private static function mejoradaOffersSections(): array
    {
        return [[
            'section' => 'Página',
            'fields' => [
                ['key' => 'offers.page_title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.rooms_page.offers_catalog.page_title'],
                ['key' => 'offers.lead', 'label' => 'Introducción', 'type' => 'textarea', 'fallback' => 'mejorada.rooms_page.offers_catalog.lead'],
            ],
        ]];
    }

    /** @return list<array{section: string, fields: list<array<string, mixed>>}> */
    private static function mejoradaRoomsSections(): array
    {
        return [[
            'section' => 'Página',
            'fields' => [
                ['key' => 'rooms_page.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.rooms_page.title'],
                ['key' => 'rooms_page.lead_1', 'label' => 'Párrafo 1', 'type' => 'textarea', 'fallback' => 'mejorada.rooms_page.lead_1'],
                ['key' => 'rooms_page.lead_2', 'label' => 'Párrafo 2', 'type' => 'textarea', 'fallback' => 'mejorada.rooms_page.lead_2'],
                ['key' => 'rooms_page.more_info', 'label' => 'Más información', 'type' => 'text', 'fallback' => 'mejorada.rooms_page.more_info'],
                ['key' => 'rooms_page.reserve', 'label' => 'Reservar', 'type' => 'text', 'fallback' => 'mejorada.rooms_page.reserve'],
            ],
        ]];
    }

    /** @return list<array{section: string, fields: list<array<string, mixed>>}> */
    private static function mejoradaRestaurantSections(): array
    {
        return [
            [
                'section' => 'Página',
                'fields' => [
                    ['key' => 'restaurant.page_title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.restaurant.page_title'],
                    ['key' => 'restaurant.lead', 'label' => 'Introducción', 'type' => 'textarea', 'fallback' => 'mejorada.restaurant.lead'],
                    ['key' => 'restaurant.book', 'label' => 'Reservar', 'type' => 'text', 'fallback' => 'mejorada.restaurant.book'],
                    ['key' => 'restaurant.see_menu', 'label' => 'Ver menú', 'type' => 'text', 'fallback' => 'mejorada.restaurant.see_menu'],
                    ['key' => 'restaurant.menu_url', 'label' => 'URL del menú', 'type' => 'text', 'fallback' => 'mejorada.restaurant.menu_url'],
                    ['key' => 'restaurant.gallery_alt', 'label' => 'Alt galería', 'type' => 'text', 'fallback' => 'mejorada.restaurant.gallery_alt'],
                    ['key' => 'restaurant.logo', 'label' => 'Logo', 'type' => 'image', 'fallback' => 'images/home/Cocina Vidente.svg', 'media' => true],
                    ['key' => 'restaurant.hero_poster', 'label' => 'Póster video', 'type' => 'image', 'fallback' => 'images/ermita/home/restaurante.png', 'media' => true],
                    ['key' => 'restaurant.hero_video', 'label' => 'Video hero', 'type' => 'video', 'fallback' => 'videos/Copia de 01. Reel RESTAURANTE Cigno MEJORADA 2.mp4', 'media' => true],
                    ['key' => 'restaurant.gallery', 'label' => 'Galería', 'type' => 'gallery', 'fallback' => 'images/mejorada/daypass-hat.jpg', 'media' => true],
                ],
            ],
            [
                'section' => 'Signature Moments',
                'fields' => [
                    ['key' => 'restaurant.signature.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.restaurant.signature.title'],
                    ['key' => 'restaurant.signature.breakfast.title', 'label' => 'Desayuno — título', 'type' => 'text', 'fallback' => 'mejorada.restaurant.signature.breakfast.title'],
                    ['key' => 'restaurant.signature.breakfast.hours', 'label' => 'Desayuno — horario', 'type' => 'text', 'fallback' => 'mejorada.restaurant.signature.breakfast.hours'],
                    ['key' => 'restaurant.signature.breakfast.body', 'label' => 'Desayuno — texto', 'type' => 'textarea', 'fallback' => 'mejorada.restaurant.signature.breakfast.body'],
                    ['key' => 'restaurant.signature.dinner.title', 'label' => 'Cena — título', 'type' => 'text', 'fallback' => 'mejorada.restaurant.signature.dinner.title'],
                    ['key' => 'restaurant.signature.dinner.body', 'label' => 'Cena — texto', 'type' => 'textarea', 'fallback' => 'mejorada.restaurant.signature.dinner.body'],
                    ['key' => 'restaurant.signature.note', 'label' => 'Nota', 'type' => 'textarea', 'fallback' => 'mejorada.restaurant.signature.note'],
                    ['key' => 'restaurant.signature.icon', 'label' => 'Icono', 'type' => 'image', 'fallback' => 'images/home/Cocina Vidente.svg', 'media' => true],
                ],
            ],
            [
                'section' => 'Chef',
                'fields' => [
                    ['key' => 'restaurant.chef.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.restaurant.chef.title'],
                    ['key' => 'restaurant.chef.body_1', 'label' => 'Párrafo 1', 'type' => 'textarea', 'fallback' => 'mejorada.restaurant.chef.body_1'],
                    ['key' => 'restaurant.chef.body_2', 'label' => 'Párrafo 2', 'type' => 'textarea', 'fallback' => 'mejorada.restaurant.chef.body_2'],
                    ['key' => 'restaurant.chef.image', 'label' => 'Foto', 'type' => 'image', 'fallback' => 'images/home/ermita.png', 'media' => true],
                ],
            ],
        ];
    }

    /** @return list<array{section: string, fields: list<array<string, mixed>>}> */
    private static function mejoradaDaypassSections(): array
    {
        return [
            [
                'section' => 'Página',
                'fields' => [
                    ['key' => 'daypass.page_title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.daypass.page_title'],
                    ['key' => 'daypass.schedule_days', 'label' => 'Días', 'type' => 'text', 'fallback' => 'mejorada.daypass.schedule_days'],
                    ['key' => 'daypass.schedule_hours', 'label' => 'Horario', 'type' => 'text', 'fallback' => 'mejorada.daypass.schedule_hours'],
                    ['key' => 'daypass.price', 'label' => 'Precio', 'type' => 'text', 'fallback' => 'mejorada.daypass.price'],
                    ['key' => 'daypass.includes', 'label' => 'Incluye', 'type' => 'textarea', 'fallback' => 'mejorada.daypass.includes'],
                    ['key' => 'daypass.restrictions', 'label' => 'Restricciones', 'type' => 'text', 'fallback' => 'mejorada.daypass.restrictions'],
                    ['key' => 'daypass.page_cta', 'label' => 'CTA', 'type' => 'text', 'fallback' => 'mejorada.daypass.page_cta'],
                    ['key' => 'daypass.gallery', 'label' => 'Galería', 'type' => 'gallery', 'fallback' => 'images/mejorada/daypass-hat.jpg', 'media' => true],
                    ['key' => 'daypass.mark', 'label' => 'Icono / marca', 'type' => 'image', 'fallback' => 'images/ermita/icons/Layer_1 (62).svg', 'media' => true],
                ],
            ],
            [
                'section' => 'Amenities',
                'fields' => [
                    ['key' => 'daypass.amenities.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.daypass.amenities.title'],
                    ['key' => 'daypass.amenities.lead', 'label' => 'Intro', 'type' => 'textarea', 'fallback' => 'mejorada.daypass.amenities.lead'],
                ],
            ],
        ];
    }

    /** @return list<array{section: string, fields: list<array<string, mixed>>}> */
    private static function mejoradaExperiencesSections(): array
    {
        return [[
            'section' => 'Página',
            'fields' => [
                ['key' => 'experiences_page.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.experiences_page.title'],
                ['key' => 'experiences_page.lead', 'label' => 'Bajada', 'type' => 'textarea', 'fallback' => 'mejorada.experiences_page.lead'],
                ['key' => 'experiences_page.intro', 'label' => 'Introducción', 'type' => 'textarea', 'fallback' => 'mejorada.experiences_page.intro'],
            ],
        ]];
    }

    /** @return list<array{section: string, fields: list<array<string, mixed>>}> */
    private static function mejoradaVenueSections(): array
    {
        return [[
            'section' => 'Página',
            'fields' => [
                ['key' => 'venue.title', 'label' => 'Título', 'type' => 'text', 'fallback' => 'mejorada.venue.title'],
                ['key' => 'venue.lead', 'label' => 'Bajada', 'type' => 'text', 'fallback' => 'mejorada.venue.lead'],
                ['key' => 'venue.intro', 'label' => 'Introducción', 'type' => 'textarea', 'fallback' => 'mejorada.venue.intro'],
                ['key' => 'venue.form_lead', 'label' => 'Texto formulario', 'type' => 'textarea', 'fallback' => 'mejorada.venue.form_lead'],
                ['key' => 'venue.gallery', 'label' => 'Galería', 'type' => 'gallery', 'fallback' => 'images/mejorada/offers/offer-1.jpg', 'media' => true],
            ],
        ]];
    }

    /** @return list<array{section: string, fields: list<array<string, mixed>>}> */
    private static function mejoradaContactSections(): array
    {
        return [[
            'section' => 'Contenido',
            'fields' => [
                ['key' => 'contact.lead_1', 'label' => 'Párrafo 1', 'type' => 'textarea', 'fallback' => 'mejorada.contact.lead_1'],
                ['key' => 'contact.lead_2', 'label' => 'Párrafo 2', 'type' => 'textarea', 'fallback' => 'mejorada.contact.lead_2'],
                ['key' => 'contact.logo', 'label' => 'Logo', 'type' => 'image', 'fallback' => 'images/ermita/icons/cisneentero.svg', 'media' => true],
            ],
        ]];
    }

    /**
     * @return list<array{section: string, fields: list<array<string, mixed>>}>
     */
    private static function legalSections(CmsPageSlug $slug): array
    {
        return [
            [
                'section' => 'Contenido',
                'fields' => [
                    ['key' => 'title', 'label' => 'Título', 'type' => 'text', 'fallback' => $slug->titleFallbackKey()],
                    ['key' => 'body', 'label' => 'Cuerpo', 'type' => 'textarea', 'fallback' => $slug->bodyFallbackKey()],
                ],
            ],
        ];
    }
}
