<?php

namespace App\Filament\Resources\Certifications\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CertificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações do Certificado')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome da Certificação')
                            ->required()
                            ->placeholder('ex: ISO 9001:2015'),

                        TextInput::make('issuer')
                            ->label('Emissor / Organismo Certificador')
                            ->required()
                            ->placeholder('ex: Bureau Veritas'),

                        TextInput::make('certificate_number')
                            ->label('Número do Certificado')
                            ->placeholder('ex: BR-12345-2025'),

                        DatePicker::make('issued_at')
                            ->label('Data de Emissão')
                            ->required()
                            ->displayFormat('d/m/Y'),

                        DatePicker::make('expires_at')
                            ->label('Data de Vencimento')
                            ->displayFormat('d/m/Y')
                            ->helperText('Deixe em branco se o certificado não expira'),

                        Textarea::make('description')
                            ->label('Descrição')
                            ->rows(3)
                            ->columnSpanFull(),

                        TextInput::make('sort_order')
                            ->label('Ordem de Exibição')
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_active')
                            ->label('Ativo')
                            ->default(true),

                        Toggle::make('show_on_home')
                            ->label('Exibir na página inicial')
                            ->default(false),
                    ])
                    ->columns(2),

                Section::make('Documento / Imagem do Certificado')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('certificate')
                            ->label('Arquivo do Certificado')
                            ->collection('certificate')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'application/pdf'])
                            ->maxSize(10240)
                            ->helperText('Envie o scan ou PDF · Máx 10 MB'),
                    ]),

                Section::make('Logotipo do Emissor')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('logo')
                            ->label('Logotipo')
                            ->collection('logo')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                            ->maxSize(2048)
                            ->helperText('SVG recomendado · Máx 2 MB'),
                    ]),
            ]);
    }
}
