<?php

namespace App\Filament\Resources\CmsPages\Schemas;

use App\Cms\PageFieldDefinitions;
use App\Models\CmsPage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
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
                    ->description('Desactivado: el sitio usa el contenido hardcodeado (archivos de idioma). Activado: se usan los campos definidos aquí; los vacíos siguen el fallback.')
                    ->schema([
                        Toggle::make('cms_enabled')
                            ->label('Conectar CMS al frontend')
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
                        $isMedia = ($field['media'] ?? false) === true
                            || in_array($field['type'] ?? null, ['image', 'gallery', 'video'], true);

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
            ? 'Fallback: '.(string) __($fallback)
            : (filled($fallback) ? 'Fallback: '.$fallback : null);

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
                    $isGallery => 'Galería (múltiples imágenes, reordenables). Fallback: '.$field['fallback'],
                    $isVideo => 'Video (mp4/mov). Fallback: '.$field['fallback'],
                    default => 'Imagen compartida para ambos idiomas. Fallback: '.$field['fallback'],
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
}
