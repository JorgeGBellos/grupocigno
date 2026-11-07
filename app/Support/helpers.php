<?php

use App\Support\CmsContent;

if (! function_exists('cms')) {
    function cms(App\Enums\CmsPageSlug|string $slug): CmsContent
    {
        return CmsContent::for($slug);
    }
}

if (! function_exists('hotel_phone_tel')) {
    function hotel_phone_tel(string $hotel): string
    {
        $digits = preg_replace('/\D+/', '', (string) config("social.phone.{$hotel}", ''));

        return filled($digits) ? 'tel:'.$digits : '#';
    }
}

if (! function_exists('hotel_phone_label')) {
    function hotel_phone_label(string $hotel): string
    {
        $label = (string) config("social.phone_label.{$hotel}", '');

        if (filled($label)) {
            return $label;
        }

        $raw = (string) config("social.phone.{$hotel}", '');

        return filled($raw) ? $raw : '';
    }
}

if (! function_exists('restaurant_menu_url')) {
    /**
     * @param  'ermita'|'mejorada'  $hotel
     * @param  'food'|'drinks'  $type
     */
    function restaurant_menu_url(string $hotel, string $type): string
    {
        $locale = app()->getLocale();
        $path = config("menus.{$hotel}.{$type}.{$locale}")
            ?? config("menus.{$hotel}.{$type}.es");

        return filled($path) ? asset($path) : '#';
    }
}
