<?php

namespace App\Filament\Resources\PortfolioItems\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PortfolioItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Item Details')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('subtitle')
                            ->maxLength(255),

                        Select::make('category')
                            ->options([
                                'CNC Turning' => 'CNC Turning',
                                'CNC Milling' => 'CNC Milling',
                                'Welding'     => 'Welding',
                                'Finishing'   => 'Finishing',
                                'Assembly'    => 'Assembly',
                            ])
                            ->required()
                            ->searchable(),

                        TextInput::make('material')
                            ->placeholder('e.g., AISI 304 Stainless Steel'),

                        TextInput::make('tolerance')
                            ->placeholder('e.g., ±0.01 mm'),

                        TextInput::make('client_name')
                            ->label('Client (optional)'),

                        Textarea::make('description')
                            ->rows(4)
                            ->columnSpanFull(),

                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_featured')
                            ->label('Featured on homepage'),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Cover Photo')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('cover')
                            ->collection('cover')
                            ->image()
                            ->imageEditor()
                            ->maxSize(5120),
                    ]),

                Section::make('Gallery Photos')
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
