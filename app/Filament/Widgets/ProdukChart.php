<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class ProdukChart extends ChartWidget
{
    protected static ?string $heading = 'Top Sales Produk';

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        return [
            'labels' => ['Produk A', 'Produk B', 'Produk C'],
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => [10, 20, 30],
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
