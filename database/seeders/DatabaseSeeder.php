<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Customer;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Warehouses
        $warehouses = Warehouse::factory()->count(3)->create();
        $mainWarehouse = $warehouses->first();

        // 2. Create Suppliers & Customers
        Supplier::factory()->count(5)->create();
        Customer::factory()->count(10)->create();

        // 3. Create Products with Categories
        $electronics = Product::factory()->electronics()->count(20)->create();
        $food = Product::factory()->foodAndBeverage()->count(20)->create();
        $fashion = Product::factory()->fashion()->count(10)->create();

        $allProducts = $electronics->merge($food)->merge($fashion);

        // 4. Generate Inventory Scenarios
        foreach ($allProducts as $index => $product) {
            // Determine Scenario based on index
            $scenario = match (true) {
                $index < 5 => 'stockout',    // First 5 products: Stockout
                $index < 15 => 'low_stock',  // Next 10 products: Low Stock
                $index < 45 => 'healthy',    // Next 30 products: Healthy
                default => 'overstock',      // Remaining: Overstock
            };

            $this->seedProductInventory($product, $scenario, $warehouses);
        }

        $this->call(OrderSeeder::class);
    }

    protected function seedProductInventory(Product $product, string $scenario, $warehouses)
    {
        $warehouse = $warehouses->random();

        // Create Batches
        $batches = Batch::factory()->count(rand(1, 3))->create([
            'product_id' => $product->id,
        ]);

        // F&B items might have expired batches
        if (str_contains($product->description, 'Perishable')) {
            Batch::factory()->expired()->create([
                'product_id' => $product->id,
                'batch_code' => 'EXP-' . rand(1000, 9999),
            ]);
        }

        $currentStock = 0;
        $targetStock = match ($scenario) {
            'stockout' => 0,
            'low_stock' => rand(1, $product->min_stock_level - 1),
            'healthy' => rand($product->min_stock_level + 10, 200),
            'overstock' => rand(1001, 2000),
        };

        // 1. Initial Inbound (Purchase)
        // If target is 0 (stockout), we still want history, so we buy then sell all.
        $initialQty = $targetStock > 0 ? $targetStock + rand(0, 50) : rand(10, 50);

        foreach ($batches as $batch) {
            $qty = (int) ceil($initialQty / $batches->count());
            InventoryTransaction::create([
                'product_id' => $product->id,
                'warehouse_id' => $warehouse->id,
                'batch_id' => $batch->id,
                'type' => 'in',
                'quantity' => $qty,
                'created_at' => now()->subMonths(2),
            ]);
            $currentStock += $qty;
        }

        // 2. Outbound Transactions (Sales) to reach target
        if ($currentStock > $targetStock) {
            $diff = $currentStock - $targetStock;

            // Split diff into multiple transactions for realism
            while ($diff > 0) {
                $qty = rand(1, $diff);
                InventoryTransaction::create([
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                    'batch_id' => $batches->random()->id,
                    'type' => 'out',
                    'quantity' => $qty,
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
                $diff -= $qty;
                $currentStock -= $qty;
            }
        }

        // 3. Random Adjustments (Loss/Found) - Optional
        if (rand(0, 10) > 8) { // 20% chance
            $type = rand(0, 1) ? 'in' : 'out';
            $qty = rand(1, 5);

            InventoryTransaction::create([
                'product_id' => $product->id,
                'warehouse_id' => $warehouse->id,
                'batch_id' => $batches->random()->id,
                'type' => $type,
                'quantity' => $qty,
                'created_at' => now(),
            ]);

            if ($type === 'in') $currentStock += $qty;
            else $currentStock -= $qty;
        }

        // 4. Update Product Total Stock
        $product->update(['total_stock' => $currentStock]);
    }
}
