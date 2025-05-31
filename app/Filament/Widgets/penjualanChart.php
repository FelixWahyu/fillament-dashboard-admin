<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class penjualanChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Trend Penjualan';

    protected static string $color = 'success';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Penjualan Produk',
                    'data' => [21, 32, 45, 74, 65, 77, 89],
                ],
            ],
            'labels' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
