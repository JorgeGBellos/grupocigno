<?php

namespace App\Enums;

enum CmsPageSlug: string
{
    case Home = 'home';
    case Contact = 'contact';
    case Club = 'club';
    case Press = 'press';
    case Shop = 'shop';
    case Cocina = 'cocina-vidente';
    case Ermita = 'cigno-ermita';
    case ErmitaRooms = 'cigno-ermita-rooms';
    case ErmitaRestaurant = 'cigno-ermita-restaurant';
    case ErmitaDaypass = 'cigno-ermita-daypass';
    case ErmitaExperiences = 'cigno-ermita-experiences';
    case ErmitaVenue = 'cigno-ermita-venue';
    case ErmitaContact = 'cigno-ermita-contact';
    case Mejorada = 'cigno-mejorada';
    case MejoradaBarrio = 'cigno-mejorada-barrio';
    case MejoradaOffers = 'cigno-mejorada-offers';
    case MejoradaRooms = 'cigno-mejorada-rooms';
    case MejoradaRestaurant = 'cigno-mejorada-restaurant';
    case MejoradaDaypass = 'cigno-mejorada-daypass';
    case MejoradaExperiences = 'cigno-mejorada-experiences';
    case MejoradaVenue = 'cigno-mejorada-venue';
    case MejoradaContact = 'cigno-mejorada-contact';
    case LegalNotice = 'legal-notice';
    case CookiesPolicy = 'cookies-policy';
    case CookieSettings = 'cookie-settings';

    public function label(): string
    {
        return match ($this) {
            self::Home => 'Inicio',
            self::Contact => 'Contacto',
            self::Club => 'Cigno Club',
            self::Press => 'Prensa',
            self::Shop => 'Tiendita',
            self::Cocina => 'Cocina Vidente',
            self::Ermita => 'Ermita — Inicio',
            self::ErmitaRooms => 'Ermita — Habitaciones',
            self::ErmitaRestaurant => 'Ermita — Restaurante',
            self::ErmitaDaypass => 'Ermita — Daypass',
            self::ErmitaExperiences => 'Ermita — Experiencias',
            self::ErmitaVenue => 'Ermita — Venue',
            self::ErmitaContact => 'Ermita — Contacto',
            self::Mejorada => 'Cigno Mejorada',
            self::MejoradaBarrio => 'Mejorada — Barrio de La Mejorada',
            self::MejoradaOffers => 'Mejorada — Ofertas',
            self::MejoradaRooms => 'Mejorada — Habitaciones',
            self::MejoradaRestaurant => 'Mejorada — Gastronomía',
            self::MejoradaDaypass => 'Mejorada — Daypass',
            self::MejoradaExperiences => 'Mejorada — Experiencias',
            self::MejoradaVenue => 'Mejorada — Venue',
            self::MejoradaContact => 'Mejorada — Contacto',
            self::LegalNotice => 'Aviso legal',
            self::CookiesPolicy => 'Política de cookies',
            self::CookieSettings => 'Configuración de cookies',
        };
    }

    public function titleFallbackKey(): string
    {
        return match ($this) {
            self::LegalNotice => 'pages.legal_notice',
            self::CookiesPolicy => 'pages.cookies_policy',
            self::CookieSettings => 'pages.cookie_settings',
            default => 'pages.legal_notice',
        };
    }

    public function bodyFallbackKey(): string
    {
        return match ($this) {
            self::LegalNotice => 'pages.legal_notice_body',
            self::CookiesPolicy => 'pages.cookies_policy_body',
            self::CookieSettings => 'pages.cookie_settings_body',
            default => 'pages.legal_notice_body',
        };
    }

    public function isLegal(): bool
    {
        return in_array($this, [self::LegalNotice, self::CookiesPolicy, self::CookieSettings], true);
    }

    public function navigationGroup(): string
    {
        return match ($this) {
            self::Home, self::Contact, self::Club, self::Press, self::Shop, self::Cocina => 'Sitio',
            self::Ermita, self::ErmitaRooms, self::ErmitaRestaurant, self::ErmitaDaypass,
            self::ErmitaExperiences, self::ErmitaVenue, self::ErmitaContact => 'Ermita',
            self::Mejorada, self::MejoradaBarrio, self::MejoradaOffers, self::MejoradaRooms,
            self::MejoradaRestaurant, self::MejoradaDaypass, self::MejoradaExperiences,
            self::MejoradaVenue, self::MejoradaContact => 'Mejorada',
            self::LegalNotice, self::CookiesPolicy, self::CookieSettings => 'Legal',
        };
    }

    public function navigationLabel(): string
    {
        return match ($this) {
            self::Home => 'Inicio',
            self::Contact => 'Contacto',
            self::Club => 'Cigno Club',
            self::Press => 'Prensa',
            self::Shop => 'Tiendita',
            self::Cocina => 'Cocina Vidente',
            self::Ermita => 'Inicio',
            self::ErmitaRooms => 'Habitaciones',
            self::ErmitaRestaurant => 'Restaurante',
            self::ErmitaDaypass => 'Daypass',
            self::ErmitaExperiences => 'Experiencias',
            self::ErmitaVenue => 'Venue',
            self::ErmitaContact => 'Contacto',
            self::Mejorada => 'Inicio',
            self::MejoradaBarrio => 'Barrio de La Mejorada',
            self::MejoradaOffers => 'Ofertas',
            self::MejoradaRooms => 'Habitaciones',
            self::MejoradaRestaurant => 'Gastronomía',
            self::MejoradaDaypass => 'Daypass',
            self::MejoradaExperiences => 'Experiencias',
            self::MejoradaVenue => 'Venue',
            self::MejoradaContact => 'Contacto',
            self::LegalNotice => 'Aviso legal',
            self::CookiesPolicy => 'Política de cookies',
            self::CookieSettings => 'Configuración de cookies',
        };
    }

    public function navigationSort(): int
    {
        return match ($this) {
            self::Home => 1,
            self::Contact => 2,
            self::Club => 3,
            self::Press => 4,
            self::Shop => 5,
            self::Cocina => 6,
            self::Ermita => 1,
            self::ErmitaRooms => 2,
            self::ErmitaRestaurant => 3,
            self::ErmitaDaypass => 4,
            self::ErmitaExperiences => 5,
            self::ErmitaVenue => 6,
            self::ErmitaContact => 7,
            self::Mejorada => 1,
            self::MejoradaBarrio => 2,
            self::MejoradaOffers => 3,
            self::MejoradaRooms => 4,
            self::MejoradaRestaurant => 5,
            self::MejoradaDaypass => 6,
            self::MejoradaExperiences => 7,
            self::MejoradaVenue => 8,
            self::MejoradaContact => 9,
            self::LegalNotice => 1,
            self::CookiesPolicy => 2,
            self::CookieSettings => 3,
        };
    }
}
