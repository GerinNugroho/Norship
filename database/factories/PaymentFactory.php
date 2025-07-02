<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'checkout_session_id' => fake()->uuid(),
            'user_id' => User::factory(),
            'amount' => fake()->randomFloat(2, 100000, 5000000),
            'provider' => fake()->randomElement(['GoPay', 'OVO', 'BCA Virtual Account']),
            'status' => 'pending',
            'transaction_id' => null,
        ];
    }
}
