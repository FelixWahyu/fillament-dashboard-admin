<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Faktur;
use App\Models\Penjualan;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsDashboard extends BaseWidget
{
    protected function getStats(): array
    {
        $fakturCount = Faktur::count();
        $pendapatan = Penjualan::sum('jumlah');
        $totalCustomer = Customer::count();

        return [
            Stat::make('Jumlah Faktur', $fakturCount . ' Faktur'),
            Stat::make('Pendapatan', 'Rp ' . number_format($pendapatan, 0, '.', '.')),
            Stat::make('Total Customer', $totalCustomer . ' Customer'),
        ];
    }
}
