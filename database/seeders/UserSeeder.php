<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'type' => 'administrator',
        ])->assignRole('Super Admin');

        User::factory()
            ->unverified()
            ->count(100)
            ->create(['type' => 'customer']);
    }
}
