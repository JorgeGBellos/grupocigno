<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MejoradaRoom extends Model
{
    protected $fillable = [
        'slug',
        'sort_order',
        'is_published',
        'title',
        'body',
        'detail',
        'price',
        'size',
        'people',
        'beds',
        'exclusive',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'body' => 'array',
            'detail' => 'array',
            'price' => 'array',
            'size' => 'array',
            'exclusive' => 'array',
            'is_published' => 'boolean',
            'people' => 'integer',
            'beds' => 'integer',
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

    public function localizedBody(?string $locale = null): string
    {
        return $this->localizedValue('body', $locale);
    }

    public function localizedDetail(?string $locale = null): string
    {
        return $this->localizedValue('detail', $locale);
    }

    public function localizedPrice(?string $locale = null): string
    {
        return $this->localizedValue('price', $locale);
    }

    public function localizedSize(?string $locale = null): string
    {
        return $this->localizedValue('size', $locale);
    }

    public function localizedValue(string $attribute, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $values = $this->{$attribute} ?? [];

        return (string) ($values[$locale] ?? $values['es'] ?? $values['en'] ?? '');
    }

    public function imageUrl(): ?string
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
