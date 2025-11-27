<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class OrdersChart extends ChartWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 2;

    protected ?string $heading = 'Orders per Month';

    protected function getData(): array
    {
        $data = [];
        $labels = [];
        $now = now();

        for ($i = 11; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $labels[] = $date->format('M Y');
            $key = $date->format('Y-m');
            $data[$key] = [
                'purchase' => 0,
                'sales' => 0,
            ];
        }

        $orders = Order::select(
            DB::raw('DATE_FORMAT(order_date, "%Y-%m") as month'),
            'type',
            DB::raw('count(*) as count')
        )
            ->where('order_date', '>=', $now->copy()->subMonths(11)->startOfMonth())
            ->groupBy('month', 'type')
            ->get();

        foreach ($orders as $order) {
            if (isset($data[$order->month])) {
                $data[$order->month][$order->type] = $order->count;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Purchase Orders',
                    'data' => array_column($data, 'purchase'),
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => '#f59e0b',
                ],
                [
                    'label' => 'Sales Orders',
                    'data' => array_column($data, 'sales'),
                    'borderColor' => '#10b981',
                    'backgroundColor' => '#10b981',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
