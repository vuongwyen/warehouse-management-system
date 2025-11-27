<?php

namespace App\Observers;

use App\Models\Order;
use App\Services\InventoryService;

class OrderObserver
{
    public function updated(Order $order)
    {
        if ($order->isDirty('status')) {
            app(InventoryService::class)->processOrder($order);
        }
    }
}
