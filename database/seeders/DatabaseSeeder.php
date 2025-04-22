<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Evento;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@test.com',
            'is_admin' => true,
        ]);

        Evento::factory(10)->create();
    }
}
