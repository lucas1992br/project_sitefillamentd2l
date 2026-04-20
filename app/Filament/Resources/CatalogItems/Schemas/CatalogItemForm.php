<?php

namespace App\Filament\Resources\CatalogItems\Schemas;

use App\Models\CatalogCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CatalogItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações do Item')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('subtitle')
                            ->label('Subtítulo')
                            ->maxLength(255),

                        Select::make('catalog_category_id')
                            ->label('Categoria')
                            ->options(CatalogCategory::active()->pluck('name', 'id'))
                            ->searchable()
                            ->nullable(),

                        TextInput::make('reference')
                            ->label('Referência')
                            ->maxLength(255)
                            ->placeholder('ex: REF-0001-AB'),

                        Textarea::make('description')
                            ->label('Descrição')
                            ->rows(4)
                            ->columnSpanFull(),

                        Textarea::make('specifications')
                            ->label('Especificações Técnicas')
                            ->rows(4)
                            ->columnSpanFull(),

                        TextInput::make('sort_order')
                            ->label('Ordem')
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_featured')
                            ->label('Destaque na página inicial'),

                        Toggle::make('is_active')
                            ->label('Visível no catálogo')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Foto de Capa')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('cover')
                            ->collection('cover')
                            ->image()
                            ->imageEditor()
                            ->maxSize(5120),
                    ]),

                Section::make('Galeria de Fotos')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('gallery')
                            ->collection('gallery')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->maxSize(5120)
                            ->maxFiles(20),
                    ]),
            ]);
    }
}
