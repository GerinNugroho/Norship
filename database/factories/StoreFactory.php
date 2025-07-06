<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->company();
        return [
            'user_id' => User::factory(),
            'name' => $name,
            'slug' => str::slug($name),
            'description' => fake()->paragraph(),
            'logo_url' => fake()->imageUrl(400, 400, 'business'),
            'address' => fake()->address(),
            'is_active' => true,
        ];
    }
}
