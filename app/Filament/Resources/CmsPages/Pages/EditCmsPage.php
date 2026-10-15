<?php

namespace App\Filament\Resources\CmsPages\Pages;

use App\Enums\CmsPageSlug;
use App\Filament\Resources\CmsPages\CmsPageResource;
use App\Models\CmsPage;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Cache;

class EditCmsPage extends EditRecord
{
    protected static string $resource = CmsPageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTitle(): string|Htmlable
    {
        $record = $this->getRecord();

        if ($record instanceof CmsPage && $record->slug instanceof CmsPageSlug) {
            return $record->slug->label();
        }

        return parent::getTitle();
    }

    public function getHeading(): string|Htmlable
    {
        return $this->getTitle();
    }

    protected function afterSave(): void
    {
        $slug = $this->record->slug;

        Cache::forget('cms.page.'.($slug instanceof CmsPageSlug ? $slug->value : $slug));
    }
}
