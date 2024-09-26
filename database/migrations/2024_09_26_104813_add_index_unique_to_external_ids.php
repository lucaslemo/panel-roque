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
        Schema::table('customers', function (Blueprint $table) {
            $table->unique('extCliente');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index('extCliente');
            $table->unique('extPedido');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->index('extCliente');
            $table->unique('extConta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex('customers_extcliente_unique');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_extcliente_index');
            $table->dropIndex('orders_extpedido_unique');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropIndex('invoices_extcliente_index');
            $table->dropIndex('invoices_extconta_unique');
        });
    }
};
