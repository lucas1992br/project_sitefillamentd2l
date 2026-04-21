<?php

namespace App\Filament\Resources\PortfolioItems\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PortfolioItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('cover')
                    ->label('Capa')
                    ->collection('cover')
                    ->conversion('thumb')
                    ->width(70)
                    ->height(50),

                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category')
                    ->label('Categoria')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'CNC Turning' => 'primary',
                        'CNC Milling' => 'success',
                        'Welding'     => 'warning',
                        'Finishing'   => 'info',
                        default       => 'gray',
                    }),

                TextColumn::make('material')
                    ->label('Material')
                    ->limit(30)
                    ->placeholder('—'),

                TextColumn::make('tolerance')
                    ->label('Tolerância')
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
                SelectFilter::make('category')
                    ->label('Categoria')
                    ->options([
                        'CNC Turning' => 'Torneamento CNC',
                        'CNC Milling' => 'Fresamento CNC',
                        'Welding'     => 'Soldagem',
                        'Finishing'   => 'Acabamento',
                        'Assembly'    => 'Montagem',
                    ]),
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
