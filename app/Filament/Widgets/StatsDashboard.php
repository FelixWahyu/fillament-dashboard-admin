<?php

namespace App\Filament\Widgets;

use App\Models\Faktur;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsDashboard extends BaseWidget
{
    protected function getStats(): array
    {
        $fakturCount = Faktur::count();

        return [
            Stat::make('Jumlah Faktur', $fakturCount . ' Faktur'),
            Stat::make('Bounce rate', '21%'),
            Stat::make('Average time on page', '3:12'),
        ];
    }
}
