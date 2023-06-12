<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'name' => 'Casper',
            'email' => '163021@student.horizoncollege.nl',
            'gitlab' => 'casperkiewski',
            'api_token' => bcrypt(env('SEEDER_TOKEN')),
            'password' => bcrypt(env('SEEDER_PASSWORD')),
        ]);
    }
}
