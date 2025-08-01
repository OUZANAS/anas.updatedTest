<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(label: 'Total Posts', value: Post::count())
                ->color('primary')
                ->icon('heroicon-o-document-text')
                ->description('Total number of posts published'),
            Stat::make(label: 'Total Categories', value: Category::count())
                ->color('secondary')
                ->icon('heroicon-o-folder')
                ->description('Total number of categories created'),
        ];
    }
}
