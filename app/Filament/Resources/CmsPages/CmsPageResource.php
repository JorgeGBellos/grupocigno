<?php

namespace App\Filament\Resources\CmsPages;

use App\Enums\CmsPageSlug;
use App\Filament\Resources\CmsPages\Pages\EditCmsPage;
use App\Filament\Resources\CmsPages\Schemas\CmsPageForm;
use App\Models\CmsPage;
use BackedEnum;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

use function Filament\Support\original_request;

class CmsPageResource extends Resource
{
    protected static ?string $model = CmsPage::class;

    protected static ?string $modelLabel = 'página';

    protected static ?string $pluralModelLabel = 'Páginas';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $slug = 'cms-pages';

    public static function form(Schema $schema): Schema
    {
        return CmsPageForm::configure($schema);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'edit' => EditCmsPage::route('/{record}'),
        ];
    }

    /**
     * @return array<NavigationItem>
     */
    public static function getNavigationItems(): array
    {
        return collect(CmsPageSlug::cases())
            ->map(function (CmsPageSlug $slug): NavigationItem {
                return NavigationItem::make($slug->navigationLabel())
                    ->key(static::class.'.'.$slug->value)
                    ->group($slug->navigationGroup())
                    ->icon(static::getNavigationIcon())
                    ->isActiveWhen(fn (): bool => original_request()->routeIs(static::getRouteBaseName().'.edit')
                        && (string) original_request()->route('record') === $slug->value)
                    ->sort($slug->navigationSort())
                    ->url(fn (): string => static::getUrl('edit', ['record' => $slug->value]));
            })
            ->all();
    }

    public static function getRecordRouteKeyName(): ?string
    {
        return 'slug';
    }

    public static function getIndexUrl(array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null, bool $shouldGuessMissingParameters = false): string
    {
        return static::getUrl('edit', ['record' => CmsPageSlug::Home->value], $isAbsolute, $panel, $tenant, $shouldGuessMissingParameters);
    }

    public static function resolveRecordRouteBinding(int|string $key, ?\Closure $modifyQuery = null): ?Model
    {
        $slug = CmsPageSlug::tryFrom((string) $key);

        if ($slug === null) {
            return CmsPage::query()->whereKey($key)->first();
        }

        return CmsPage::query()->firstOrCreate(
            ['slug' => $slug],
            [
                'name' => $slug->label(),
                'cms_enabled' => false,
                'content' => [],
            ],
        );
    }

    public static function getRecordTitle(?Model $record): string|Htmlable|null
    {
        if ($record instanceof CmsPage && $record->slug instanceof CmsPageSlug) {
            return $record->slug->label();
        }

        return parent::getRecordTitle($record);
    }

    public static function hasRecordTitle(): bool
    {
        return true;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }
}
