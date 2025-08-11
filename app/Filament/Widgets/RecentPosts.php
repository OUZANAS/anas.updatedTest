<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentPosts extends BaseWidget
{
    protected static ?string $heading = 'Recent posts';
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return false; // Explicitly hide from dashboard
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(Post::query()->latest())
            ->defaultPaginationPageOption(10)
            ->defaultSort('updated_at', 'desc')
            ->paginated([10, 25, 50])
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Image')
                    ->circular()
                    ->height(36),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->limit(50)
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('category.title')
                    ->label('Category')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('published')
                    ->label('Published')
                    ->query(fn ($q) => $q->where('is_published', true)),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->icon('heroicon-o-pencil-square')
                    ->url(fn ($record) => route('filament.admin.resources.posts.edit', $record))
                    ->button(),
                Tables\Actions\Action::make('view')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => url('/posts/' . $record->slug))
                    ->openUrlInNewTab(),
            ]);
    }
}
