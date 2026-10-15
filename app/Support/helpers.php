<?php

use App\Support\CmsContent;

if (! function_exists('cms')) {
    function cms(App\Enums\CmsPageSlug|string $slug): CmsContent
    {
        return CmsContent::for($slug);
    }
}
