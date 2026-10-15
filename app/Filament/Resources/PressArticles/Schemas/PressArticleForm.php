<?php

namespace App\Filament\Resources\PressArticles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PressArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Publicación')
                    ->schema([
                        TextInput::make('publication')
                            ->label('Medio')
                            ->required()
                            ->maxLength(120),
                        TextInput::make('url')
                            ->label('URL del artículo')
                            ->url()
                            ->maxLength(500),
                        TextInput::make('sort_order')
                            ->label('Orden')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('is_published')
                            ->label('Publicado')
                            ->default(true),
                        FileUpload::make('image')
                            ->label('Logo del medio')
                            ->disk('public')
                            ->directory('cms/press')
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
                                Textarea::make('excerpt.es')
                                    ->label('Extracto')
                                    ->rows(5)
                                    ->required(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                TextInput::make('title.en')
                                    ->label('Title')
                                    ->maxLength(255),
                                Textarea::make('excerpt.en')
                                    ->label('Excerpt')
                                    ->rows(5),
                            ]),
                    ]),
            ]);
    }
}
