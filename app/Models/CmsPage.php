<?php

namespace App\Models;

use App\Enums\CmsPageSlug;
use Illuminate\Database\Eloquent\Model;

class CmsPage extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'cms_enabled',
        'content',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getRouteKey(): mixed
    {
        $slug = $this->getAttribute('slug');

        return $slug instanceof CmsPageSlug ? $slug->value : $slug;
    }

    protected function casts(): array
    {
        return [
            'slug' => CmsPageSlug::class,
            'cms_enabled' => 'boolean',
            'content' => 'array',
        ];
    }
}
