<?php

namespace Database\Seeders;

use App\Models\BillToReceive;
use App\Models\CreditLimit;
use App\Models\Organization;
use App\Models\Sale;
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
        ]);

        User::factory()->count(4)->create(['type' => 'administrator']);

        for($i = 0; $i < 145; $i++) {
            User::factory()
                ->unverified()
                ->has(
                    Organization::factory()->count(rand(1, 2))
                        ->has(CreditLimit::factory())
                        ->has(BillToReceive::factory()->count(30), 'billsToReceive')
                        ->has(Sale::factory()->count(15))
                )
                ->create(['type' => 'customer']);
        }  
    }
}
