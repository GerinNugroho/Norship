<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->randomElement(['Rumah', 'Kantor', 'Apartemen']),
            'recipient_name' => fake()->name(),
            'phone_number' => fake()->phoneNumber(),
            'address_1' => fake()->streetAddress(),
            'address_2' => fake()->secondaryAddress(),
            'country' => 'Indonesia',
            'province' => fake()->state(),
            'regency' => fake()->city(),
            'district' => fake()->citySuffix(),
            'postal_code' => fake()->postcode(),
            'is_default' => false,
        ];
    }
}
