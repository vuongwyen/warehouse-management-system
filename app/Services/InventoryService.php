<?php

namespace App\Services;

use App\Models\Batch;
use App\Models\InventoryTransaction;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    public function processOrder(Order $order)
    {
        // Prevent double processing if already processed?
        // For MVP, assume status transition is enough.

        if ($order->status === 'received' && $order->type === 'purchase') {
            $this->processInboundOrder($order);
        } elseif ($order->status === 'shipped' && $order->type === 'sales') {
            $this->processOutboundOrder($order);
        }
    }

    protected function processInboundOrder(Order $order)
    {
        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                // Create or Find Batch
                $batch = null;
                if ($item->batch_code) {
                    $batch = Batch::firstOrCreate(
                        ['product_id' => $item->product_id, 'batch_code' => $item->batch_code],
                        ['expiry_date' => $item->expiry_date]
                    );
                    $item->update(['batch_id' => $batch->id]);
                } elseif ($item->batch_id) {
                    $batch = $item->batch;
                }

                // Create Transaction
                InventoryTransaction::create([
                    'product_id' => $item->product_id,
                    'warehouse_id' => 1, // Default warehouse for MVP
                    'batch_id' => $batch?->id,
                    'type' => 'in',
                    'quantity' => $item->quantity,
                    'reference_type' => Order::class,
                    'reference_id' => $order->id,
                ]);

                // Update Product Total Stock
                $item->product->increment('total_stock', $item->quantity);
            }
        });
    }

    protected function processOutboundOrder(Order $order)
    {
        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                // Create Transaction
                InventoryTransaction::create([
                    'product_id' => $item->product_id,
                    'warehouse_id' => 1, // Default warehouse
                    'batch_id' => $item->batch_id,
                    'type' => 'out',
                    'quantity' => $item->quantity,
                    'reference_type' => Order::class,
                    'reference_id' => $order->id,
                ]);

                // Update Product Total Stock
                $item->product->decrement('total_stock', $item->quantity);
            }
        });
    }
}
