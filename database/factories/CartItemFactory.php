<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\ProductSku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cart_id' => Cart::factory(),
            'products_sku_id' => ProductSku::factory(),
            'quantity' => fake()->numberBetween(1, 5),
        ];
    }
}
