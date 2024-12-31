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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('idPedido')->comment('Chave primária da tabela');
            $table->unsignedBigInteger('idCliente')->nullable()->comment('Foreign key para a tabela clientes');
            $table->unsignedBigInteger('idPedidoCabecalho')->nullable()->comment('Foreign key para a tabela filiais');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
