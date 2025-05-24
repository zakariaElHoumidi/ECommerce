<?php

namespace Database\Factories;

use App\Models\Category;
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
            'category_id' => Category::all()->random()->id,
            'label' => fake()->word(),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 0, 100),
            'quantity' => fake()->randomNumber(2),
        ];
    }
}
