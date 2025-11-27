<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('type')
                    ->options([
                        'purchase' => 'Purchase Order (Inbound)',
                        'sales' => 'Sales Order (Outbound)',
                    ])
                    ->required()
                    ->live(),
                Forms\Components\Select::make('supplier_id')
                    ->relationship('supplier', 'name')
                    ->visible(fn(Get $get) => $get('type') === 'purchase')
                    ->required(fn(Get $get) => $get('type') === 'purchase'),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->visible(fn(Get $get) => $get('type') === 'sales')
                    ->required(fn(Get $get) => $get('type') === 'sales'),
                Forms\Components\DatePicker::make('order_date')
                    ->required()
                    ->default(now()),
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'confirmed' => 'Confirmed',
                        'shipped' => 'Shipped',
                        'received' => 'Received',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('draft'),
                Forms\Components\Repeater::make('items')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->relationship('product', 'name')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn($state, Set $set) => $set('unit_price', Product::find($state)?->price ?? 0)),
                        Forms\Components\TextInput::make('quantity')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('unit_price')
                            ->numeric()
                            ->required(),

                        // Inbound: Enter Batch Code
                        Forms\Components\TextInput::make('batch_code')
                            ->visible(fn(Get $get) => $get('../../type') === 'purchase')
                            ->required(fn(Get $get) => $get('../../type') === 'purchase'),
                        Forms\Components\DatePicker::make('expiry_date')
                            ->visible(fn(Get $get) => $get('../../type') === 'purchase'),

                        // Outbound: Select Batch
                        Forms\Components\Select::make('batch_id')
                            ->relationship('batch', 'batch_code', fn($query, Get $get) => $query->where('product_id', $get('product_id')))
                            ->visible(fn(Get $get) => $get('../../type') === 'sales')
                            ->required(fn(Get $get) => $get('../../type') === 'sales'),
                    ])
                    ->columns(4),
            ]);
    }
}
