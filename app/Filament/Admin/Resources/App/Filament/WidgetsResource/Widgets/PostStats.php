<?php

namespace App\Filament\Admin\Resources\App\Filament\WidgetsResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Post;

class PostStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Posts', Post::count())
                ->description('All posts in system')
                ->chart($this->getPostTrend())
                ->color('success'),

            Stat::make('Scheduled Posts', Post::where('status', 'scheduled')->count())
                ->description('Waiting to be published')
                ->color('warning')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => "dispatch('open-modal', { id: 'scheduled-posts' })",
                ]),

            Stat::make('Published Today', Post::where('status', 'published')
                ->whereDate('scheduled_time', today())
                ->count())
                ->description('Successful publications today')
                ->color('info'),

            Stat::make('Avg Posts/Day', $this->getAveragePosts())
                ->description('Last 30 days average')
                ->color('primary'),
        ];
    }

    protected function getPostTrend(): array
    {
        return Post::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();
    }

    protected function getAveragePosts(): float
    {
        return round(Post::where('created_at', '>=', now()->subDays(30))
            ->count() / 30, 1);
    }
}
