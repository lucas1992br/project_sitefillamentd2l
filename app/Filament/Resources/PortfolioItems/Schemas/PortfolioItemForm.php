<?php

namespace App\Filament\Resources\PortfolioItems\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PortfolioItemForm
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
                            ->maxLength(255),

                        TextInput::make('subtitle')
                            ->label('Subtítulo')
                            ->maxLength(255),

                        Textarea::make('description')
                            ->label('Descrição')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Detalhes Técnicos')
                    ->schema([
                        Select::make('category')
                            ->label('Categoria')
                            ->options([
                                'Turnkey'     => 'Turnkey',
                                'Usinagem'    => 'Usinagem',
                                'Caldeiraria' => 'Caldeiraria',
                                'Restauração' => 'Restauração',
                            ])
                            ->required()
                            ->searchable(),

                        TextInput::make('material')
                            ->label('Material')
                            ->placeholder('ex: Aço Inox AISI 304'),

                        TextInput::make('tolerance')
                            ->label('Tolerância')
                            ->placeholder('ex: ±0.01 mm'),

                        TextInput::make('client_name')
                            ->label('Cliente (opcional)'),

                        TextInput::make('sort_order')
                            ->label('Ordem de Exibição')
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_featured')
                            ->label('Destaque na página inicial'),

                        Toggle::make('is_active')
                            ->label('Ativo')
                            ->default(true),

                        Toggle::make('show_on_home')
                            ->label('Exibir na página inicial')
                            ->default(false),
                    ])
                    ->columns(2),

                Section::make('Foto de Capa')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('cover')
                            ->label('Imagem de Capa')
                            ->collection('cover')
                            ->image()
                            ->imageEditor()
                            ->maxSize(5120),
                    ]),

                Section::make('Galeria de Fotos')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('gallery')
                            ->label('Imagens')
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
