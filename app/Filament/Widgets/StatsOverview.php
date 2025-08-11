<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Post;
use App\Models\Career;
use App\Models\City;
use App\Models\JobType;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    // Higher sort order to appear at the top
    protected static ?int $sort = 1;
    
    // Use full width
    protected int | string | array $columnSpan = 'full';
    
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
            Stat::make(label: 'Total Careers', value: Career::count())
                ->color('success')
                ->icon('heroicon-o-briefcase')
                ->description('Total number of job listings'),
            Stat::make(label: 'Total Cities', value: City::count())
                ->color('warning')
                ->icon('heroicon-o-map-pin')
                ->description('Available locations'),
            Stat::make(label: 'Job Types', value: JobType::count())
                ->color('danger')
                ->icon('heroicon-o-identification')
                ->description('Available job types'),
        ];
    }
}
