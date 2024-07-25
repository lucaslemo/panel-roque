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
        Schema::create('order_history', function (Blueprint $table) {
            // Campos da tabela
            $table->id('idHistoricoPedido')->comment('Chave primária da tabela');
            $table->unsignedBigInteger('idPedidoCabecalho')->comment('Foreign key para a tabela de pedidos');

            $table->string('nmStatusPedido')->comment('Status de mudança do pedido');
            $table->dateTime('dtStatusPedido')->comment('Data da mudança de status');

            $table->timestamps();
            $table->softDeletes();

            // Indexes da tabela
            $table->foreign('idPedidoCabecalho')->references('idPedidoCabecalho')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_history');
    }
};
