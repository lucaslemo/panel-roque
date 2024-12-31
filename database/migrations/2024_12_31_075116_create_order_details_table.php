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
            // Campos da tabela
            $table->id('idPedido')->comment('Chave primária da tabela');
            $table->unsignedBigInteger('idCliente')->nullable()->comment('Foreign key para a tabela clientes');
            $table->unsignedBigInteger('idPedidoCabecalho')->nullable()->comment('Foreign key para a tabela filiais');

            $table->string('codProduto')->comment('Código do produto');
            $table->string('nmProduto')->comment('Descrição do produto');
            $table->decimal('qtdProduto', $precision = 13, $scale = 4)->comment('Quantidade do produto');
            $table->string('cdUnidade')->comment('Unidade do produto');
            $table->decimal('vrTabela', $precision = 15, $scale = 2)->comment('Valor do produto na tabela');
            $table->decimal('vrDesconto', $precision = 15, $scale = 2)->comment('Valor do desconto');
            $table->decimal('vrProduto', $precision = 15, $scale = 2)->comment('Valor do produto');
            $table->decimal('vrTotal', $precision = 15, $scale = 2)->comment('Valor Total');

            $table->timestamps();
            $table->softDeletes();

            // Indexes da tabela
            $table->foreign('idCliente')->references('idCliente')->on('customers')->onDelete('cascade');
            $table->foreign('idPedidoCabecalho')->references('idPedidoCabecalho')->on('orders')->onDelete('cascade');
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
