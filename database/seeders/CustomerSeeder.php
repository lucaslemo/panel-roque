<?php

namespace Database\Seeders;

use App\Models\CreditLimit;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            User::where('type', 'customer')->chunk(100, function($users) {
                foreach($users as $user) {
                    Customer::factory()
                        ->count(rand(1, 2))
                        ->has(CreditLimit::factory())
                        ->hasAttached($user)
                        ->create();
                }
            });

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
