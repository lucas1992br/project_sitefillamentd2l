<?php

namespace App\Filament\Resources\Certifications\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CertificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Certificate Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->placeholder('e.g., ISO 9001:2015'),

                        TextInput::make('issuer')
                            ->required()
                            ->placeholder('e.g., Bureau Veritas'),

                        TextInput::make('certificate_number')
                            ->placeholder('e.g., BR-12345-2025'),

                        DatePicker::make('issued_at')
                            ->required()
                            ->label('Issue Date')
                            ->displayFormat('d/m/Y'),

                        DatePicker::make('expires_at')
                            ->label('Expiration Date')
                            ->displayFormat('d/m/Y')
                            ->helperText('Leave blank if the certificate does not expire'),

                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),

                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Certificate Document / Image')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('certificate')
                            ->collection('certificate')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'application/pdf'])
                            ->maxSize(10240)
                            ->helperText('Upload scan or PDF · Max 10 MB'),
                    ]),

                Section::make('Issuer Logo')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('logo')
                            ->collection('logo')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                            ->maxSize(2048)
                            ->helperText('SVG preferred · Max 2 MB'),
                    ]),
            ]);
    }
}
