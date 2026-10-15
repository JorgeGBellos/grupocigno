<?php

namespace App\Filament\Resources\ShopItems\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ShopItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Producto')
                    ->schema([
                        TextInput::make('sort_order')
                            ->label('Orden')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('is_published')
                            ->label('Publicado')
                            ->default(true),
                        FileUpload::make('image')
                            ->label('Imagen')
                            ->disk('public')
                            ->directory('cms/shop')
                            ->visibility('public')
                            ->image(),
                    ]),
                Tabs::make('Contenido')
                    ->tabs([
                        Tab::make('Español')
                            ->schema([
                                TextInput::make('category.es')
                                    ->label('Categoría')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('brand.es')
                                    ->label('Marca')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('body.es')
                                    ->label('Descripción')
                                    ->rows(5)
                                    ->required(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                TextInput::make('category.en')
                                    ->label('Category')
                                    ->maxLength(255),
                                TextInput::make('brand.en')
                                    ->label('Brand')
                                    ->maxLength(255),
                                Textarea::make('body.en')
                                    ->label('Description')
                                    ->rows(5),
                            ]),
                    ]),
            ]);
    }
}
