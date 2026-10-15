<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PressArticle extends Model
{
    protected $fillable = [
        'title',
        'excerpt',
        'publication',
        'url',
        'image',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'excerpt' => 'array',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderByDesc('created_at');
    }

    public function localizedTitle(?string $locale = null): string
    {
        return $this->localizedValue('title', $locale);
    }

    public function localizedExcerpt(?string $locale = null): string
    {
        return $this->localizedValue('excerpt', $locale);
    }

    public function localizedValue(string $attribute, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $values = $this->{$attribute} ?? [];

        return (string) ($values[$locale] ?? $values['es'] ?? $values['en'] ?? '');
    }

    public function logoUrl(): ?string
    {
        if (blank($this->image)) {
            return null;
        }

        if (str_starts_with($this->image, 'http') || str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }

        return Storage::disk('public')->url($this->image);
    }
}
