<?php

namespace App\Filament\Widgets;

use App\Models\Career;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentCareers extends BaseWidget
{
    protected static ?string $heading = 'Recent careers';

    public static function canView(): bool
    {
        return false; // Explicitly hide from dashboard
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(Career::query()->latest())
            ->defaultPaginationPageOption(10)
            ->defaultSort('updated_at', 'desc')
            ->paginated([10, 25, 50])
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->limit(50)
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('company_name')
                    ->label('Company')
                    ->badge(),
                Tables\Columns\TextColumn::make('city.name')
                    ->label('City')
                    ->badge(),
                Tables\Columns\TextColumn::make('jobType.name')
                    ->label('Job Type')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->label('Active')
                    ->query(fn ($q) => $q->where('is_active', true)),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->icon('heroicon-o-pencil-square')
                    ->url(fn ($record) => route('filament.admin.resources.careers.edit', $record))
                    ->button(),
            ]);
    }
}
