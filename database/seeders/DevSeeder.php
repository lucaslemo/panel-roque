<?php

namespace Database\Seeders;

use App\Models\CreditLimit;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\User;
use Carbon\Carbon;
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
                ->count(20)
                ->state(new Sequence(
                    fn (Sequence $sequence) => ['type' => 2],
                ))
                ->deactivated()
                ->has(Customer::factory()->count(3)->has(CreditLimit::factory()))
                ->create();

            User::with('customers')->chunk(500, function(Collection $users) {
                foreach ($users as $user) {
                    foreach($user->customers as $customer) {
                        $customer->emailCliente = $user->email;
                        $customer->save();
                    }
                }
            });

            Customer::chunk(500, function(Collection $customers) {
                foreach ($customers as $customer) {
                    Order::factory()
                        ->count(rand(1, 3))
                        ->state(new Sequence(
                            fn (Sequence $sequence) => ['extCliente' => $customer->extCliente],
                        ))
                        ->for($customer)
                        ->create();
                }
            });

            $orderHistories = ['Entregue', 'Em trânsito', 'Devolvido', 'Reprogramado', 'Montado', 'Separado'];
            Order::chunk(500, function(Collection $orders) use($orderHistories) {
                foreach ($orders as $order) {
                    Invoice::factory()
                    ->count(rand(2, 3))
                    ->state(new Sequence(
                        fn (Sequence $sequence) => [
                            'extCliente' => $order->extCliente,
                            'extPedido' => $order->extPedido,
                            'idCliente' => $order->idCliente,
                        ],
                    ))
                    ->for($order)
                    ->create();

                    $orderKey = array_search($order->statusPedido, $orderHistories);
                    $date = Carbon::parse($order->dtPedido);
                    $date2 = Carbon::parse($order->dtPedido)->addMinutes(rand(1000, 10000));
                    foreach($orderHistories as $key => $orderHistory) {
                        if ($key > $orderKey) {
                            $date2 = fake()->dateTimeBetween($date, $date2);
                            OrderHistory::create([
                                'idPedidoCabecalho' => $order->idPedidoCabecalho,
                                'nmStatusPedido' => $orderHistory,
                                'dtStatusPedido' => $date2,
                            ]);
                        }
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
