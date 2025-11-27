<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku' => $this->faker->unique()->bothify('??-####'),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'base_unit' => 'pcs',
            'min_stock_level' => $this->faker->numberBetween(10, 50),
            'total_stock' => 0, // Will be calculated by seeder
        ];
    }

    public function electronics(): Factory
    {
        return $this->state(function (array $attributes) {
            $names = [
                'RTX 4090',
                'Dell XPS 15',
                'MacBook Pro M3',
                'Sony WH-1000XM5',
                'Samsung Odyssey G9',
                'Keychron Q1 Pro',
                'Logitech MX Master 3S',
                'iPhone 15 Pro',
                'iPad Air 5',
                'Nintendo Switch OLED'
            ];
            return [
                'name' => $this->faker->randomElement($names) . ' ' . $this->faker->bothify('##??'),
                'base_unit' => 'unit',
                'min_stock_level' => 5,
                'description' => 'High value electronics item.',
            ];
        });
    }

    public function foodAndBeverage(): Factory
    {
        return $this->state(function (array $attributes) {
            $names = [
                'Robusta Coffee Beans',
                'Almond Milk',
                'Oat Milk',
                'Green Tea Matcha',
                'Dark Chocolate 70%',
                'Organic Honey',
                'Premium Rice 5kg',
                'Olive Oil Extra Virgin',
                'Sparkling Water',
                'Dried Mango'
            ];
            return [
                'name' => $this->faker->randomElement($names),
                'base_unit' => 'pack',
                'min_stock_level' => 100,
                'description' => 'Perishable goods. Check expiry.',
            ];
        });
    }

    public function fashion(): Factory
    {
        return $this->state(function (array $attributes) {
            $types = ['T-Shirt', 'Jeans', 'Hoodie', 'Sneakers', 'Cap', 'Jacket'];
            $sizes = ['S', 'M', 'L', 'XL'];
            $colors = ['Black', 'White', 'Navy', 'Red', 'Grey'];

            $name = $this->faker->randomElement($types) . ' ' .
                $this->faker->randomElement($colors) . ' Size ' .
                $this->faker->randomElement($sizes);

            return [
                'name' => $name,
                'base_unit' => 'pcs',
                'min_stock_level' => 20,
                'description' => 'Apparel and fashion accessories.',
            ];
        });
    }
}
