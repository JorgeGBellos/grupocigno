<?php

namespace App\Filament\Resources\ErmitaRooms\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ErmitaRoomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Habitación')
                    ->schema([
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(120)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, callable $set): void {
                                if (filled($state)) {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        TextInput::make('sort_order')
                            ->label('Orden')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('is_published')
                            ->label('Publicado')
                            ->default(true),
                        TextInput::make('people')
                            ->label('Personas')
                            ->numeric()
                            ->minValue(1)
                            ->required(),
                        TextInput::make('beds')
                            ->label('Camas')
                            ->numeric()
                            ->minValue(1)
                            ->required(),
                        TagsInput::make('exclusive')
                            ->label('Exclusivos')
                            ->placeholder('Añadir amenity exclusiva'),
                        FileUpload::make('image')
                            ->label('Imagen')
                            ->disk('public')
                            ->directory('cms/ermita-rooms')
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
                                Textarea::make('body.es')
                                    ->label('Resumen')
                                    ->rows(4)
                                    ->required(),
                                Textarea::make('detail.es')
                                    ->label('Detalle')
                                    ->rows(5)
                                    ->required(),
                                TextInput::make('price.es')
                                    ->label('Precio')
                                    ->required()
                                    ->maxLength(120),
                                TextInput::make('size.es')
                                    ->label('Tamaño')
                                    ->required()
                                    ->maxLength(120),
                            ]),
                        Tab::make('English')
                            ->schema([
                                TextInput::make('title.en')
                                    ->label('Title')
                                    ->maxLength(255),
                                Textarea::make('body.en')
                                    ->label('Summary')
                                    ->rows(4),
                                Textarea::make('detail.en')
                                    ->label('Detail')
                                    ->rows(5),
                                TextInput::make('price.en')
                                    ->label('Price')
                                    ->maxLength(120),
                                TextInput::make('size.en')
                                    ->label('Size')
                                    ->maxLength(120),
                            ]),
                    ]),
            ]);
    }
}
