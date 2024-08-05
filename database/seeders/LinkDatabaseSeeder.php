<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LinkDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            Customer::chunk(500, function($customers) {
                foreach($customers as $customer) {
                    Order::where('extCliente', $customer->extCliente)->chunk(500, function($orders) use($customer) {
                        foreach($orders as $order) {
                            $order->idCliente = $customer->idCliente;
                            $order->save();
                        }
                    });

                    Invoice::where('extCliente', $customer->extCliente)->chunk(500, function($invoices) use($customer) {
                        foreach($invoices as $invoice) {
                            $invoice->idCliente = $customer->idCliente;
                            $invoice->save();
                        }
                    });
                }
            });

            Order::chunk(500, function ($orders) {
                foreach($orders as $order) {
                    Invoice::where('extPedido', $order->extPedido)->chunk(500, function($invoices) use($order) {
                        foreach($invoices as $invoice) {
                            $invoice->idPedidoCabecalho = $order->idPedidoCabecalho;
                            $invoice->save();
                        }
                    });
                }
            });

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
