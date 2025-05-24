<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 5; $i++) {
            Product::create([
                'category_id' => Category::all()->random()->id,
                'label' => "Product " . $i,
                'description' => "Description product " . $i,
                'price' => rand(10, 100),
                'quantity' => rand(1, 10)
            ]);
        }
    }
}
