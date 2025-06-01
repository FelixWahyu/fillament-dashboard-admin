<?php

namespace App\Filament\Widgets;

use App\Models\Penjualan;
use Carbon\Carbon;
use Flowframe\Trend\Trend;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\TrendValue;

class penjualanChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Trend Penjualan';

    protected static string $color = 'success';

    protected function getData(): array
    {
        $data = Trend::model(Penjualan::class)
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
            ->sum('jumlah');

        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan Harian',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate)->toArray(),
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => Carbon::parse($value->date)->format('d M'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
