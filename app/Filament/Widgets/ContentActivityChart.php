<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use App\Models\Post;
use App\Models\Career;
use Illuminate\Support\Carbon;

class ContentActivityChart extends LineChartWidget
{
    protected static ?string $heading = '30-day activity';

    protected function getData(): array
    {
        $start = now()->subDays(29)->startOfDay();
        $end = now()->endOfDay();

        $labels = collect(range(0, 29))
            ->map(fn ($i) => $start->clone()->addDays($i)->format('M d'))
            ->toArray();

        $postCounts = Post::whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->groupBy('d')
            ->pluck('c', 'd');

        $careerCounts = Career::whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->groupBy('d')
            ->pluck('c', 'd');

        $dates = collect(range(0, 29))
            ->map(fn ($i) => $start->clone()->addDays($i)->toDateString());

        $posts = $dates->map(fn ($d) => (int) ($postCounts[$d] ?? 0))->toArray();
        $careers = $dates->map(fn ($d) => (int) ($careerCounts[$d] ?? 0))->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Posts',
                    'data' => $posts,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.15)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Careers',
                    'data' => $careers,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.15)',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
