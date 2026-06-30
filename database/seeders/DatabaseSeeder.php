<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        User::factory()->create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
        ]);

        User::factory()->create([
            'name' => 'Member User',
            'email' => 'member@example.com',
        ]);

        $this->call([
            RoleSeeder::class,
            DemoSeeder::class,
        ]);
    }
}
