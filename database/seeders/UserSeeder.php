<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            // Users admin
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@email.com',
                'type' => 'administrator',
                'cpf' => '17475528014',
            ]);

            // User::factory()
            //     ->count(2)
            //     ->deleted()
            //     ->create(['type' => 'administrator']);

            // User::factory()
            //     ->count(2)
            //     ->unverified()
            //     ->deactivated()
            //     ->create(['type' => 'administrator']);

            // // Users customer
            // User::factory()
            //     ->create([
            //         'name' => 'User',
            //         'email' => 'user@email.com',
            //         'type' => 'customer',
            //     ]);

            // User::factory()
            //     ->count(50)
            //     ->deleted()
            //     ->create(['type' => 'customer']);

            // User::factory()
            //     ->count(9)
            //     ->unverified()
            //     ->deactivated()
            //     ->create(['type' => 'customer']);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
