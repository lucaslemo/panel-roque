<?php

namespace Database\Seeders;

use App\Models\CreditLimit;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            User::factory()
                ->count(1000)
                ->state(new Sequence(
                    fn (Sequence $sequence) => ['type' => rand(2, 3)],
                ))
                ->has(Customer::factory()->count(rand(1, 5))->has(CreditLimit::factory()))
                ->create();

            User::factory()
                ->count(200)
                ->state(new Sequence(
                    fn (Sequence $sequence) => ['type' => rand(2, 3)],
                ))
                ->deactivated()
                ->has(Customer::factory()->count(rand(1, 5))->has(CreditLimit::factory()))
                ->create();

            User::with('customers')->chunk(500, function(Collection $users) {
                foreach ($users as $user) {
                    foreach($user->customers as $customer) {
                        $customer->emailCliente = $user->email;
                        $customer->save();
                    }
                }
            });

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

    }
}
