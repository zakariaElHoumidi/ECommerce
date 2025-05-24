<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 5; $i++) {
            Rating::create([
                'user_id' => User::all()->random()->id,
                'product_id' => Product::all()->random()->id,
                'rating' => $i + 1,
                'review' => fake()->sentence()
            ]);
        }
    }
}
