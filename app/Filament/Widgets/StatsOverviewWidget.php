<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Question;
use App\Models\TestSession;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Active Questions', Question::active()->count()),
            Stat::make('Pass Rate (30d)', TestSession::recentPassRate().'%'),
            Stat::make('Tests Today', TestSession::today()->completed()->count()),
        ];
    }
}
