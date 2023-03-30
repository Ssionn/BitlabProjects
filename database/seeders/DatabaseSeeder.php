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
        User::factory()->create([
            'name' => 'test',
            'email' => 'test@test.com',
            'gitlab' => 'casperkiewski',
            'api_token' => 'glpat-6QLzzXtHWptRxiyUhzL4',
            'password' => bcrypt('password'),
        ]);
    }
}
