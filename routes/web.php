<?php

use App\Http\Controllers\BookingRedirectController;
use App\Http\Controllers\ContactLeadController;
use App\Http\Controllers\ErmitaRoomController;
use App\Http\Controllers\MejoradaRoomController;
use App\Http\Controllers\SetLocaleController;
use App\Http\Controllers\VenueInquiryController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/booking', BookingRedirectController::class)->name('booking.search');
Route::view('/design-system', 'design-system')->name('design-system');

Route::get('/locale/{locale}', SetLocaleController::class)
    ->whereIn('locale', ['es', 'en'])
    ->name('locale.update');

Route::view('/cigno-ermita', 'cigno-ermita')->name('cigno-ermita');
Route::view('/cigno-ermita/barrio', 'ermita.barrio')->name('cigno-ermita.barrio');
Route::view('/cigno-ermita/offers', 'ermita.offers')->name('cigno-ermita.offers');
Route::view('/cigno-ermita/rooms', 'ermita.rooms')->name('cigno-ermita.rooms');
Route::get('/cigno-ermita/rooms/{slug}', [ErmitaRoomController::class, 'show'])
    ->name('cigno-ermita.rooms.show');
Route::view('/cigno-ermita/daypass', 'ermita.daypass')->name('cigno-ermita.daypass');
Route::view('/cigno-ermita/contact', 'ermita.contact')->name('cigno-ermita.contact');
Route::view('/cigno-ermita/contact/gracias', 'ermita.contact-thank-you')->name('cigno-ermita.contact.thank-you');
Route::view('/cigno-ermita/restaurant', 'ermita.restaurant')->name('cigno-ermita.restaurant');
Route::view('/cigno-ermita/experiences', 'ermita.experiences')->name('cigno-ermita.experiences');
Route::view('/cigno-ermita/venue', 'ermita.venue')->name('cigno-ermita.venue');
Route::post('/cigno-ermita/venue', VenueInquiryController::class)->name('cigno-ermita.venue.store');
Route::view('/cigno-ermita/venue/gracias', 'ermita.venue-thank-you')->name('cigno-ermita.venue.thank-you');

Route::view('/cigno-mejorada', 'cigno-mejorada')->name('cigno-mejorada');
Route::view('/cigno-mejorada/barrio-mejorada', 'mejorada.story')->name('cigno-mejorada.story');
Route::redirect('/cigno-mejorada/barrio', '/cigno-mejorada/barrio-mejorada', 301);
Route::view('/cigno-mejorada/offers', 'mejorada.offers')->name('cigno-mejorada.offers');
Route::view('/cigno-mejorada/rooms', 'mejorada.rooms')->name('cigno-mejorada.rooms');
Route::get('/cigno-mejorada/rooms/{slug}', [MejoradaRoomController::class, 'show'])
    ->name('cigno-mejorada.rooms.show');
Route::view('/cigno-mejorada/daypass', 'mejorada.daypass')->name('cigno-mejorada.daypass');
Route::view('/cigno-mejorada/contact', 'mejorada.contact')->name('cigno-mejorada.contact');
Route::view('/cigno-mejorada/contact/gracias', 'mejorada.contact-thank-you')->name('cigno-mejorada.contact.thank-you');
Route::view('/cigno-mejorada/restaurant', 'mejorada.restaurant')->name('cigno-mejorada.restaurant');
Route::view('/cigno-mejorada/experiences', 'mejorada.experiences')->name('cigno-mejorada.experiences');
Route::view('/cigno-mejorada/venue', 'mejorada.venue')->name('cigno-mejorada.venue');
Route::post('/cigno-mejorada/venue', VenueInquiryController::class)->name('cigno-mejorada.venue.store');
Route::view('/cigno-mejorada/venue/gracias', 'mejorada.venue-thank-you')->name('cigno-mejorada.venue.thank-you');
Route::view('/cigno-club', 'cigno-club')->name('cigno-club');
Route::view('/cocina-vidente', 'cocina-vidente')->name('cocina-vidente');
Route::view('/press', 'press')->name('press');
Route::view('/shop', 'shop')->name('shop');
Route::view('/contact', 'contact')->name('contact');
Route::post('/contact', ContactLeadController::class)->name('contact.store');
Route::view('/contact/gracias', 'contact-thank-you')->name('contact.thank-you');

Route::view('/legal-notice', 'legal', ['cmsSlug' => 'legal-notice'])->name('legal-notice');
Route::view('/cookies-policy', 'legal', ['cmsSlug' => 'cookies-policy'])->name('cookies-policy');
Route::view('/cookie-settings', 'legal', ['cmsSlug' => 'cookie-settings'])->name('cookie-settings');
