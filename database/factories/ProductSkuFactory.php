<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductSku>
 */
class ProductSkuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'sku' => strtoupper(fake()->bothify('??-####')),
            'price' => fake()->randomFloat(2, 50000, 1000000),
            'quantity' => fake()->numberBetween(0, 100),
            'image_url' => fake()->imageUrl(640, 480, 'technics'),
        ];
    }
}
