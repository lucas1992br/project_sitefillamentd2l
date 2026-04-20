<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Client Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('industry')
                            ->placeholder('e.g., Automotive, Oil & Gas, Aerospace'),

                        TextInput::make('website')
                            ->url()
                            ->placeholder('https://client.com'),

                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_featured')
                            ->label('Show testimonial on homepage'),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Testimonial')
                    ->schema([
                        Textarea::make('testimonial')
                            ->rows(4)
                            ->columnSpanFull(),

                        TextInput::make('contact_name')
                            ->label('Contact Name'),

                        TextInput::make('contact_role')
                            ->label('Contact Role')
                            ->placeholder('e.g., Procurement Manager'),
                    ])
                    ->columns(2),

                Section::make('Client Logo')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('logo')
                            ->collection('logo')
                            ->image()
                            ->imageEditor()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                            ->maxSize(2048)
                            ->helperText('PNG transparent or SVG preferred · Max 2 MB'),
                    ]),
            ]);
    }
}
