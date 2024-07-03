<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\IndependentSalesRepresentative;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            User::with('customers.creditLimit')->where('type', 'customer')->chunk(100, function($users) {
                foreach($users as $user) {
                    $branchs = Branch::factory()->count(rand(2, 3))->create();
                    $rcas = IndependentSalesRepresentative::factory()->count(rand(2, 3))->create();

                    foreach($user->customers as $customer) {
                        $branch = $branchs->random();
                        $rca = $rcas->random();
                        $orders = Order::factory()
                            ->count(rand(15, 30))
                            ->for($customer)
                            ->for($branch)
                            ->for($rca)
                            ->create(['vrTotal' => 0]);

                        foreach($orders as $order) {
                            $orderItems = OrderItem::factory()
                                ->count(rand(3, 20))
                                ->for($order)
                                ->create();

                            foreach($orderItems as $orderItem) {
                                $order->vrTotal += ($orderItem->numQuantidade * $orderItem->vrUnitario);
                            }
                            $order->save();

                            foreach($orders as $order) {
                                $qtyInvoices = rand(2, 12);
                                $invoices = Invoice::factory()
                                    ->count($qtyInvoices)
                                    ->for($customer)
                                    ->for($order)
                                    ->for($branch)
                                    ->for($rca)
                                    ->create();

                                foreach($invoices as $key => $invoice) {
                                    $invoice->tpCobranca = $order->tpCobranca;
                                    $invoice->dtEmissao = $order->dtFaturamento;
                                    $invoice->dtVencimento = Carbon::parse($order->dtFaturamento)->addDays(46);
                                    $invoice->dtParcela = Carbon::parse($order->dtFaturamento)->subDays($qtyInvoices)->addDays($key);
                                    $invoice->vrBruto = $order->vrTotal / $qtyInvoices;
                                    $invoice->vrLiquido = $invoice->vrBruto;
                                    $invoice->vrAtualizado = $invoice->vrBruto;
                                    $invoice->vrPago = !is_null($invoice->vrPago) ? $invoice->vrBruto : null;
                                    $invoice->save();
                                }
                            }
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
