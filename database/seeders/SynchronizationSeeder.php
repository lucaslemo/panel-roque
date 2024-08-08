<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Synchronization;
use App\Models\SynchronizationDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SynchronizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            Synchronization::factory()
                ->has(SynchronizationDetail::factory([
                        'nmEntidade' => Customer::class,
                        'numDadosAtualizados' => 0,
                        'numDadosAtualizar' => 0,
                        'isCompleto' => true,
                    ]),
                    'syncDetails'
                )
                ->has(SynchronizationDetail::factory([
                        'nmEntidade' => Order::class,
                        'numDadosAtualizados' => 0,
                        'numDadosAtualizar' => 0,
                        'isCompleto' => true,
                    ]),
                    'syncDetails'
                )
                ->has(SynchronizationDetail::factory([
                        'nmEntidade' => Invoice::class,
                        'numDadosAtualizados' => 0,
                        'numDadosAtualizar' => 0,
                        'isCompleto' => true,
                    ]),
                    'syncDetails'
                )
                ->create();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
