<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class SetLocaleController
{
    public function __invoke(string $locale): RedirectResponse
    {
        abort_unless(array_key_exists($locale, config('languages.available')), 404);

        session(['locale' => $locale]);

        return back();
    }
}
