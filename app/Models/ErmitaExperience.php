<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ErmitaExperience extends Model
{
    protected $fillable = [
        'slug',
        'sort_order',
        'is_published',
        'title',
        'paragraphs',
        'subtitle',
        'subtitle_body',
        'tag',
        'cta',
        'cta_url',
        'image',
        'expandable',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'paragraphs' => 'array',
            'subtitle' => 'array',
            'subtitle_body' => 'array',
            'tag' => 'array',
            'cta' => 'array',
            'is_published' => 'boolean',
            'expandable' => 'boolean',
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

    public function localizedSubtitle(?string $locale = null): string
    {
        return $this->localizedValue('subtitle', $locale);
    }

    public function localizedSubtitleBody(?string $locale = null): string
    {
        return $this->localizedValue('subtitle_body', $locale);
    }

    public function localizedTag(?string $locale = null): string
    {
        return $this->localizedValue('tag', $locale);
    }

    public function localizedCta(?string $locale = null): string
    {
        return $this->localizedValue('cta', $locale);
    }

    /**
     * @return list<string>
     */
    public function localizedParagraphs(?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();
        $values = $this->paragraphs ?? [];

        $paragraphs = $values[$locale] ?? $values['es'] ?? $values['en'] ?? [];

        if (! is_array($paragraphs)) {
            return [];
        }

        return array_values(array_filter(array_map(
            fn (mixed $paragraph): string => trim((string) $paragraph),
            $paragraphs,
        )));
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
