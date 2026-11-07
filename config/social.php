<?php

return [
    'instagram' => [
        'main' => env('INSTAGRAM_CIGNO_URL', 'https://www.instagram.com/cignohoteles/'),
        'ermita' => env('INSTAGRAM_ERMITA_URL', 'https://www.instagram.com/cignohotelermita/'),
        'mejorada' => env('INSTAGRAM_MEJORADA_URL', 'https://www.instagram.com/cignohotelmejorada/'),
    ],
    'phone' => [
        'ermita' => env('PHONE_ERMITA', '+529901036917'),
        'mejorada' => env('PHONE_MEJORADA', '+529993389675'),
    ],
    'phone_label' => [
        'ermita' => env('PHONE_ERMITA_LABEL', '+52 990 103 6917'),
        'mejorada' => env('PHONE_MEJORADA_LABEL', '+52 999 338 9675'),
    ],
];
