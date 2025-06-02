<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Detail;
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
        $totalProdukTerjual = Detail::sum('qty');

        return [
            Stat::make('Jumlah Faktur', $fakturCount . ' Faktur'),
            Stat::make('Total Pendapatan', 'Rp ' . number_format($pendapatan, 0, '.', '.')),
            Stat::make('Total Produk Terjual', $totalProdukTerjual . ' Produk'),
            Stat::make('Total Customer', $totalCustomer . ' Customer'),
        ];
    }
}
