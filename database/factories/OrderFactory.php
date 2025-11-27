<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(['purchase', 'sales']);
        $status = match ($type) {
            'purchase' => $this->faker->randomElement(['draft', 'confirmed', 'received', 'cancelled']),
            'sales' => $this->faker->randomElement(['draft', 'confirmed', 'shipped', 'cancelled']),
        };

        return [
            'order_number' => strtoupper($this->faker->bothify($type === 'purchase' ? 'PO-#####' : 'SO-#####')),
            'supplier_id' => $type === 'purchase' ? Supplier::factory() : null,
            'customer_id' => $type === 'sales' ? Customer::factory() : null,
            'type' => $type,
            'status' => $status,
            'order_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }

    public function purchase(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'purchase',
            'order_number' => strtoupper($this->faker->bothify('PO-#####')),
            'customer_id' => null,
            'supplier_id' => Supplier::inRandomOrder()->first()?->id ?? Supplier::factory(),
            'status' => $this->faker->randomElement(['draft', 'confirmed', 'received', 'cancelled']),
        ]);
    }

    public function sales(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'sales',
            'order_number' => strtoupper($this->faker->bothify('SO-#####')),
            'supplier_id' => null,
            'customer_id' => Customer::inRandomOrder()->first()?->id ?? Customer::factory(),
            'status' => $this->faker->randomElement(['draft', 'confirmed', 'shipped', 'cancelled']),
        ]);
    }
}
