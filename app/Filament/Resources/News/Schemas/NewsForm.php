<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Conteúdo')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, callable $set) {
                                if ($operation === 'create') {
                                    $set('slug', \Illuminate\Support\Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Textarea::make('excerpt')
                            ->label('Resumo')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        RichEditor::make('body')
                            ->label('Conteúdo')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Publicação')
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Publicado')
                            ->default(false),

                        DateTimePicker::make('published_at')
                            ->label('Data de Publicação')
                            ->native(false),

                        TextInput::make('sort_order')
                            ->label('Ordem de Exibição')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(3),

                Section::make('Imagem de Capa')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('cover')
                            ->label('Imagem')
                            ->collection('cover')
                            ->image()
                            ->imageEditor()
                            ->maxSize(5120),
                    ]),
            ]);
    }
}
