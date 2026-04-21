<?php

namespace App\Filament\Resources\Clients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('logo')
                    ->label('Logo')
                    ->collection('logo')
                    ->conversion('thumb')
                    ->width(80)
                    ->height(40),

                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('industry')
                    ->label('Setor')
                    ->placeholder('—'),

                TextColumn::make('testimonial')
                    ->label('Depoimento')
                    ->limit(50)
                    ->placeholder('Sem depoimento'),

                TextColumn::make('contact_name')
                    ->label('Contato')
                    ->placeholder('—'),

                IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Destaque'),

                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Ativo'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                TernaryFilter::make('is_featured')->label('Destaque'),
                TernaryFilter::make('is_active')->label('Ativo'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
