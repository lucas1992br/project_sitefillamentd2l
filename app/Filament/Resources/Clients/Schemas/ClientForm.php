<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações do Cliente')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome do Cliente')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('industry')
                            ->label('Setor / Indústria')
                            ->placeholder('ex: Automotivo, Petróleo & Gás, Aeroespacial'),

                        TextInput::make('website')
                            ->label('Site')
                            ->url()
                            ->placeholder('https://cliente.com.br'),

                        TextInput::make('sort_order')
                            ->label('Ordem de Exibição')
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_featured')
                            ->label('Exibir depoimento na página inicial'),

                        Toggle::make('is_active')
                            ->label('Ativo')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Depoimento')
                    ->schema([
                        Textarea::make('testimonial')
                            ->label('Depoimento')
                            ->rows(4)
                            ->columnSpanFull(),

                        TextInput::make('contact_name')
                            ->label('Nome do Contato'),

                        TextInput::make('contact_role')
                            ->label('Cargo do Contato')
                            ->placeholder('ex: Gerente de Compras'),
                    ])
                    ->columns(2),

                Section::make('Logotipo do Cliente')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('logo')
                            ->label('Logotipo')
                            ->collection('logo')
                            ->downloadable()
                            ->deletable()
                            ->previewable()
                            ->image()
                            ->imageEditor()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                            ->maxSize(2048)
                            ->helperText('PNG transparente ou SVG recomendado · Máx 2 MB'),
                    ]),
            ]);
    }
}
