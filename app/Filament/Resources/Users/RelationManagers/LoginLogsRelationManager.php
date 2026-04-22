<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LoginLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'loginLogs';

    protected static ?string $title = 'Histórico de Acessos';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('logged_in_at')
                    ->label('Data / Hora')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->description(fn ($record) => $record->logged_in_at->diffForHumans()),

                TextColumn::make('ip_address')
                    ->label('IP')
                    ->placeholder('—')
                    ->copyable()
                    ->copyMessage('IP copiado'),

                TextColumn::make('user_agent')
                    ->label('Navegador / Dispositivo')
                    ->limit(60)
                    ->placeholder('—')
                    ->tooltip(fn ($record) => $record->user_agent),
            ])
            ->defaultSort('logged_in_at', 'desc')
            ->filters([
                Filter::make('ultima_semana')
                    ->label('Última semana')
                    ->query(fn (Builder $query) => $query->where('logged_in_at', '>=', now()->subWeek()))
                    ->default(),

                Filter::make('ultimo_mes')
                    ->label('Último mês')
                    ->query(fn (Builder $query) => $query->where('logged_in_at', '>=', now()->subMonth())),
            ]);
    }
}
