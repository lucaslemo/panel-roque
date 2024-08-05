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
        Schema::create('payment_type', function (Blueprint $table) {
            // Campos da tabela
            $table->id('idPagamento')->comment('Chave primária da tabela');
            $table->unsignedBigInteger('idPedidoCabecalho')->nullable()->comment('Foreign key para a tabela pedidos');

            $table->string('tpPagamento')->comment('Tipo de pagamento');
            $table->string('vrValor')->comment('Valor do tipo de pagamento');

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
        Schema::dropIfExists('payment_type');
    }
};
