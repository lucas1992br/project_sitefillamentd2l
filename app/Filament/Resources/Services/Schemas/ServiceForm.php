<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações Básicas')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn (string $operation, string $state, Set $set) =>
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                            ),

                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('subtitle')
                            ->label('Subtítulo')
                            ->maxLength(255),

                        RichEditor::make('description')
                            ->label('Descrição')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold', 'italic', 'bulletList', 'orderedList', 'h2', 'h3', 'link',
                            ]),

                        TextInput::make('icon')
                            ->label('Ícone')
                            ->placeholder('heroicon-o-wrench-screwdriver')
                            ->helperText('Nome do Heroicon (ex: heroicon-o-fire)'),

                        TextInput::make('sort_order')
                            ->label('Ordem de Exibição')
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_active')
                            ->label('Visível no site')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Foto de Capa')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('cover')
                            ->label('Imagem de Capa')
                            ->collection('cover')
                            ->image()
                            ->imageEditor()
                            ->maxSize(5120)
                            ->helperText('Recomendado: 800×600 px · Máx 5 MB'),
                    ]),

                Section::make('Galeria de Imagens')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('gallery')
                            ->label('Imagens')
                            ->collection('gallery')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->maxSize(5120)
                            ->maxFiles(10),
                    ]),
            ]);
    }
}
