<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            return;
        }

        // 1. Create Purchase Orders
        Order::factory()->purchase()->count(20)->create()->each(function (Order $order) use ($products) {
            $this->createOrderItems($order, $products);
        });

        // 2. Create Sales Orders
        Order::factory()->sales()->count(30)->create()->each(function (Order $order) use ($products) {
            $this->createOrderItems($order, $products);
        });
    }

    protected function createOrderItems(Order $order, $products)
    {
        $numItems = rand(1, 5);

        for ($i = 0; $i < $numItems; $i++) {
            $product = $products->random();
            $batch = Batch::where('product_id', $product->id)->inRandomOrder()->first();

            OrderItem::factory()->create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'batch_id' => $batch?->id,
                'batch_code' => $batch?->batch_code,
                'expiry_date' => $batch?->expiry_date,
                'quantity' => rand(1, 20),
                'unit_price' => $product->price ?? rand(10, 100),
            ]);
        }
    }
}
