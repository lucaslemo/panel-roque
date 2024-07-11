<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('clientes', 'customers');
        Schema::rename('usuariosPossuemClientes', 'users_has_customers');
        Schema::rename('contas', 'invoices');
        Schema::rename('filiais', 'companies');
        Schema::rename('limitesDeCredito', 'credit_limits');
        Schema::rename('pedidosCabecalhos', 'orders');
        Schema::rename('pedidosItens', 'order_items');
        Schema::rename('representantesComerciaisAutonomos', 'sellers');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('customers', 'clientes');
        Schema::rename('users_has_customers', 'usuariosPossuemClientes');
        Schema::rename('invoices', 'contas');
        Schema::rename('companies', 'filiais');
        Schema::rename('credit_limits', 'limitesDeCredito');
        Schema::rename('orders', 'pedidosCabecalhos');
        Schema::rename('order_items', 'pedidosItens');
        Schema::rename('sellers', 'representantesComerciaisAutonomos');

    }
};
