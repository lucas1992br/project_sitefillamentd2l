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
                    ->collection('cover')
                    ->conversion('thumb')
                    ->width(70)
                    ->height(50),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'CNC Turning' => 'primary',
                        'CNC Milling' => 'success',
                        'Welding'     => 'warning',
                        'Finishing'   => 'info',
                        default       => 'gray',
                    }),

                TextColumn::make('material')
                    ->limit(30)
                    ->placeholder('—'),

                TextColumn::make('tolerance')
                    ->placeholder('—'),

                IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),

                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                SelectFilter::make('category')
                    ->options([
                        'CNC Turning' => 'CNC Turning',
                        'CNC Milling' => 'CNC Milling',
                        'Welding'     => 'Welding',
                        'Finishing'   => 'Finishing',
                        'Assembly'    => 'Assembly',
                    ]),
                TernaryFilter::make('is_featured'),
                TernaryFilter::make('is_active'),
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
