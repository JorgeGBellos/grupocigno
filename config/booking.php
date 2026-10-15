<?php

return [
    'base_url' => env('BOOKING_BASE_URL', 'https://www.cignohotel.com'),
    'home' => env('BOOKING_HOME_URL', 'https://www.cignohotel.com/'),
    'idchain' => env('BOOKING_IDCHAIN', '522722'),
    'idtokenprovider' => env('BOOKING_IDTOKENPROVIDER', '100380967'),
    'client_code' => env('BOOKING_CLIENT_CODE', 'test'),
    'hsri' => env('BOOKING_HSRI', '02080'),
    'currency' => env('BOOKING_CURRENCY', 'MXN'),
    'max_nights' => (int) env('BOOKING_MAX_NIGHTS', 30),
    'max_advance_days' => (int) env('BOOKING_MAX_ADVANCE_DAYS', 365),
    'max_rooms' => 4,
    'max_adults_per_room' => 4,
    'max_total_guests' => 8,
    'hotels' => [
        'cigno-mejorada' => [
            'selector' => env('BOOKING_MEJORADA_SELECTOR', '76818'),
        ],
        'cigno-ermita' => [
            'selector' => env('BOOKING_ERMITA_SELECTOR', '76818'),
        ],
    ],
];
