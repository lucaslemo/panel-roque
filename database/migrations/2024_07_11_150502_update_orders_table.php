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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('tpPedido');
            $table->dropColumn('statusEntrega');
            $table->dropColumn('dtCriacao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('tpPedido')->nullable()->comment('Tipo do pedido');
            $table->string('statusEntrega')->nullable()->comment('Status da entrega');
            $table->dateTime('dtCriacao')->comment('Data da criação');
        });
    }
};
