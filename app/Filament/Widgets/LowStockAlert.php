<?php

namespace App\Filament\Widgets;

use App\Models\Batch;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LowStockAlert extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Products', Product::count()),
            Stat::make('Low Stock Items', Product::whereColumn('total_stock', '<', 'min_stock_level')->count())
                ->description('Items below minimum level')
                ->color('danger'),
            Stat::make('Expiring Batches (30 days)', Batch::where('expiry_date', '<=', now()->addDays(30))->count())
                ->description('Batches expiring soon')
                ->color('warning'),
        ];
    }
}
