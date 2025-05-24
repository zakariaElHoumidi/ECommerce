<?php

namespace Database\Seeders;

use App\Models\Administrateur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdministrateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Administrateur::create([
            'firstname' => "zakaria",
            'lastname' => "el houmidi",
            'email' => "zakaria@houmidi.com",
            'password' => Hash::make("password"),
            'cin' => "BJ482955"
        ]);
    }
}
