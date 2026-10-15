<?php

namespace App\Filament\Resources\ErmitaExperiences\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ErmitaExperienceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Experiencia')
                    ->schema([
                        TextInput::make('sort_order')
                            ->label('Orden')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('is_published')
                            ->label('Publicado')
                            ->default(true),
                        Toggle::make('expandable')
                            ->label('Expandible')
                            ->default(false),
                        TextInput::make('cta_url')
                            ->label('URL del CTA')
                            ->maxLength(500),
                        FileUpload::make('image')
                            ->label('Imagen')
                            ->disk('public')
                            ->directory('cms/ermita-experiences')
                            ->visibility('public')
                            ->image(),
                    ]),
                Tabs::make('Contenido')
                    ->tabs([
                        Tab::make('Español')
                            ->schema([
                                TextInput::make('title.es')
                                    ->label('Título')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('tag.es')
                                    ->label('Etiqueta')
                                    ->maxLength(255),
                                TextInput::make('subtitle.es')
                                    ->label('Subtítulo')
                                    ->maxLength(255),
                                Textarea::make('subtitle_body.es')
                                    ->label('Texto del subtítulo')
                                    ->rows(3),
                                TextInput::make('cta.es')
                                    ->label('CTA')
                                    ->maxLength(255),
                                Repeater::make('paragraphs.es')
                                    ->label('Párrafos')
                                    ->simple(
                                        Textarea::make('paragraph')
                                            ->label('Párrafo')
                                            ->rows(3)
                                            ->required(),
                                    )
                                    ->defaultItems(1)
                                    ->addActionLabel('Añadir párrafo')
                                    ->reorderable(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                TextInput::make('title.en')
                                    ->label('Title')
                                    ->maxLength(255),
                                TextInput::make('tag.en')
                                    ->label('Tag')
                                    ->maxLength(255),
                                TextInput::make('subtitle.en')
                                    ->label('Subtitle')
                                    ->maxLength(255),
                                Textarea::make('subtitle_body.en')
                                    ->label('Subtitle body')
                                    ->rows(3),
                                TextInput::make('cta.en')
                                    ->label('CTA')
                                    ->maxLength(255),
                                Repeater::make('paragraphs.en')
                                    ->label('Paragraphs')
                                    ->simple(
                                        Textarea::make('paragraph')
                                            ->label('Paragraph')
                                            ->rows(3),
                                    )
                                    ->defaultItems(0)
                                    ->addActionLabel('Add paragraph')
                                    ->reorderable(),
                            ]),
                    ]),
            ]);
    }
}
