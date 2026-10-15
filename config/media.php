<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Background / promotional videos
    |--------------------------------------------------------------------------
    |
    | Temporarily disable site videos (heroes, carousels, menu) and show
    | poster images instead. Set VIDEOS_ENABLED=true in .env to re-enable.
    |
    */

    'videos_enabled' => (bool) env('VIDEOS_ENABLED', false),

];
