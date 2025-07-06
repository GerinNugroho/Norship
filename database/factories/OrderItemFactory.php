<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\ProductSku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'products_sku_id' => ProductSku::factory(),
            'quantity' => fake()->numberBetween(1, 3),
            'price_at_purchase' => fake()->randomFloat(2, 50000, 1000000),
            'product_name_snapshot' => fake()->words(3, true),
        ];
    }
}
