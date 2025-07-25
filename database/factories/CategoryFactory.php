<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);
        return [
            // 'parent_id' => null,// Top-level category by default
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'icon_url' => fake()->imageUrl(100, 100, 'abstract'),
        ];
    }
}
