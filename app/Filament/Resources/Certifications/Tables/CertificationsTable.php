<?php

namespace App\Filament\Resources\Certifications\Tables;

use App\Models\Certification;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CertificationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('logo')
                    ->label('Logo')
                    ->collection('logo')
                    ->conversion('thumb')
                    ->width(60)
                    ->height(40),

                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('issuer')
                    ->label('Emissor')
                    ->searchable(),

                TextColumn::make('certificate_number')
                    ->label('Número')
                    ->placeholder('—'),

                TextColumn::make('issued_at')
                    ->label('Emitido em')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('expires_at')
                    ->label('Vencimento')
                    ->date('d/m/Y')
                    ->placeholder('Sem vencimento')
                    ->color(fn (Certification $record): string => $record->isExpired() ? 'danger' : 'success'),

                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Ativo'),

                IconColumn::make('show_on_home')
                    ->boolean()
                    ->label('Na home'),
            ])
            ->defaultSort('sort_order')
            ->filters([
                TernaryFilter::make('is_active')->label('Ativo'),
                TernaryFilter::make('show_on_home')->label('Na home'),
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
