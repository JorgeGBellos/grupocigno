<?php

namespace App\Filament\Resources\CmsPages\Schemas;

use App\Cms\PageFieldDefinitions;
use App\Models\CmsPage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CmsPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('CMS')
                    ->description('Desactivado: el sitio usa lang/ y assets por defecto. Activado: los campos rellenados aquí sustituyen al frontend; si un campo queda vacío, sigue el fallback (lang o ruta de media). Catálogos (habitaciones, experiencias, prensa, tienda) se editan en sus menús CRUD aparte.')
                    ->schema([
                        Toggle::make('cms_enabled')
                            ->label('Conectar CMS al frontend')
                            ->helperText('Vacío = fallback. No hace falta rellenar todos los campos para activar la página.')
                            ->inline(false),
                        Placeholder::make('slug_info')
                            ->label('Página')
                            ->content(fn (?CmsPage $record): string => $record?->name ?? ''),
                    ]),
                Tabs::make('Contenido')
                    ->tabs([
                        Tab::make('Español')
                            ->schema(fn (?CmsPage $record): array => self::localeSections($record, 'es')),
                        Tab::make('English')
                            ->schema(fn (?CmsPage $record): array => self::localeSections($record, 'en')),
                    ]),
            ]);
    }

    /**
     * @return list<Section>
     */
    private static function localeSections(?CmsPage $record, string $locale): array
    {
        if (! $record) {
            return [];
        }

        return collect(PageFieldDefinitions::sections($record->slug))
            ->map(function (array $section) use ($record, $locale): ?Section {
                $fields = collect($section['fields'])
                    ->map(function (array $field) use ($record, $locale) {
                        $type = $field['type'] ?? 'text';

                        if ($type === 'repeater') {
                            return self::repeaterField($field, $record, $locale);
                        }

                        $isMedia = ($field['media'] ?? false) === true
                            || in_array($type, ['image', 'gallery', 'video'], true);

                        // Medios compartidos: solo en pestaña Español para evitar campos duplicados.
                        if ($isMedia) {
                            return $locale === 'es'
                                ? self::mediaField($field, $record)
                                : null;
                        }

                        return self::textField($field, $locale);
                    })
                    ->filter()
                    ->values()
                    ->all();

                if ($fields === []) {
                    return null;
                }

                $description = $locale === 'en'
                    ? 'Textos en inglés. Imágenes y videos se editan en la pestaña Español (compartidos).'
                    : null;

                return Section::make($section['section'])
                    ->description($description)
                    ->schema($fields);
            })
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @param  array<string, mixed>  $field
     */
    private static function textField(array $field, string $locale): TextInput|Textarea
    {
        $name = 'content.'.$locale.'.'.$field['key'];
        $fallback = $field['fallback'] ?? '';
        $helper = filled($fallback) && ! str_starts_with((string) $fallback, 'images/') && ! str_starts_with((string) $fallback, 'videos/')
            ? 'Vacío = lang. Fallback: '.(string) __($fallback)
            : (filled($fallback) ? 'Vacío = asset. Fallback: '.$fallback : 'Vacío = sin override');

        return match ($field['type'] ?? 'text') {
            'textarea' => Textarea::make($name)
                ->label($field['label'])
                ->rows(4)
                ->helperText($helper),
            default => TextInput::make($name)
                ->label($field['label'])
                ->helperText($helper),
        };
    }

    /**
     * @param  array<string, mixed>  $field
     */
    private static function mediaField(array $field, CmsPage $record): FileUpload
    {
        $name = 'content.media.'.$field['key'];
        $type = $field['type'] ?? 'image';
        $isGallery = $type === 'gallery';
        $isVideo = $type === 'video';

        $upload = FileUpload::make($name)
            ->label($field['label'])
            ->disk('public')
            ->directory('cms/'.$record->slug->value)
            ->visibility('public')
            ->helperText(
                match (true) {
                    $isGallery => 'Vacío = fallback. Galería reordenable. Fallback: '.$field['fallback'],
                    $isVideo => 'Vacío = fallback. Video mp4/mov/webm. Fallback: '.$field['fallback'],
                    default => 'Vacío = fallback. Imagen compartida ES/EN. Fallback: '.$field['fallback'],
                }
            );

        if ($isVideo) {
            $upload
                ->acceptedFileTypes([
                    'video/mp4',
                    'video/quicktime',
                    'video/webm',
                ])
                ->maxSize(1024 * 100);
        } else {
            $upload->image();
        }

        if ($isGallery) {
            $upload->multiple()->reorderable();
        }

        return $upload;
    }

    /**
     * @param  array<string, mixed>  $field
     */
    private static function repeaterField(array $field, CmsPage $record, string $locale): Repeater
    {
        $name = 'content.'.$locale.'.'.$field['key'];
        $fallback = $field['fallback'] ?? '';
        $itemFields = collect($field['item_fields'] ?? [])
            ->map(function (array $itemField) use ($record, $locale) {
                $type = $itemField['type'] ?? 'text';

                if ($type === 'image') {
                    if ($locale !== 'es') {
                        return null;
                    }

                    return FileUpload::make($itemField['key'])
                        ->label($itemField['label'])
                        ->disk('public')
                        ->directory('cms/'.$record->slug->value)
                        ->visibility('public')
                        ->image()
                        ->helperText('Imagen compartida ES/EN. Vacío = usa imagen del fallback lang.');
                }

                if ($type === 'textarea') {
                    return Textarea::make($itemField['key'])
                        ->label($itemField['label'])
                        ->rows(3);
                }

                return TextInput::make($itemField['key'])
                    ->label($itemField['label']);
            })
            ->filter()
            ->values()
            ->all();

        $helper = $locale === 'en'
            ? 'Textos EN. Las imágenes se editan en Español (se emparejan por orden).'
            : (filled($fallback) ? 'Vacío = lang. Fallback: '.$fallback : 'Vacío = sin override');

        return Repeater::make($name)
            ->label($field['label'])
            ->schema($itemFields)
            ->collapsible()
            ->reorderable()
            ->defaultItems(0)
            ->helperText($helper);
    }
}
