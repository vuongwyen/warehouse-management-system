<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockProducts extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()->whereColumn('total_stock', '<', 'min_stock_level')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\TextColumn::make('sku')->sortable(),
                Tables\Columns\TextColumn::make('total_stock')
                    ->label('Current Stock')
                    ->color('danger')
                    ->sortable(),
                Tables\Columns\TextColumn::make('min_stock_level')->label('Min Level'),
            ]);
    }
}
