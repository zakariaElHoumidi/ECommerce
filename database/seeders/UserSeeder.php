<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'firstname' => "marouane",
            'lastname' => "mahboub",
            'email' => "marouane@mahboub.com",
            'password' => Hash::make("password"),
            'address' => "tacharouk",
            'city' => "casablanca",
            'phone' => "0706452165"
        ]);
    }
}
