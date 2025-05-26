<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 5; $i++) {
            Cart::create([
                'user_id' => User::all()->random()->id,
                'product_id' => Product::all()->random()->id,
                'quantity' => rand(1, 10)
            ]);
        }
    }
}
