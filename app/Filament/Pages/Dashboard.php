<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\penjualanChart;
use App\Filament\Widgets\ProdukChart;
use App\Filament\Widgets\StatsDashboard;
use Filament\Pages\Dashboard as PagesDashboard;

class Dashboard extends PagesDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';

    public function getHeaderWidgets(): array
    {
        return [
            StatsDashboard::class,
        ];
    }

    public function getFooterWidgets(): array
    {
        return [
            penjualanChart::class,
            ProdukChart::class,
        ];
    }
}
