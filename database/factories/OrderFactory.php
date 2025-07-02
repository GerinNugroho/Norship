<?php

namespace Database\Factories;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subTotal = fake()->randomFloat(2, 100000, 5000000);
        $shippingCost = fake()->randomFloat(2, 10000, 50000);

        return [
            'user_id' => User::factory(),
            'store_id' => Store::factory(),
            'checkout_session_id' => fake()->uuid(),
            'invoice_number' => 'INV/' . now()->year . '/' . strtoupper(fake()->lexify('???')) . '/' . fake()->unique()->randomNumber(6),
            'status' => 'waiting_for_payment',
            'shipping_address' => fake()->address(),
            'shipping_provider' => fake()->randomElement(['JNE', 'SiCepat', 'Anteraja']),
            'shipping_tracking_number' => null,
            'sub_total' => $subTotal,
            'shipping_cost' => $shippingCost,
            'grand_total' => $subTotal + $shippingCost,
        ];
    }
}
