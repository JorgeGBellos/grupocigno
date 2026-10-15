<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ShopItem extends Model
{
    protected $fillable = [
        'category',
        'brand',
        'body',
        'image',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'category' => 'array',
            'brand' => 'array',
            'body' => 'array',
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

    public function localizedCategory(?string $locale = null): string
    {
        return $this->localizedValue('category', $locale);
    }

    public function localizedBrand(?string $locale = null): string
    {
        return $this->localizedValue('brand', $locale);
    }

    public function localizedBody(?string $locale = null): string
    {
        return $this->localizedValue('body', $locale);
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
