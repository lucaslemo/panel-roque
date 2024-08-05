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
        Schema::create('orders', function (Blueprint $table) {
            // Campos da tabela
            $table->id('idPedidoCabecalho')->comment('Chave primária da tabela');
            $table->unsignedBigInteger('idCliente')->nullable()->comment('Foreign key para a tabela clientes');
            $table->unsignedBigInteger('idFilial')->nullable()->comment('Foreign key para a tabela filiais');

            $table->string('extCliente')->comment('Código externo do cliente');
            $table->string('extPedido')->comment('Código externo do pedido');
            $table->string('nmVendedor')->comment('Nome do vendedor');
            $table->string('tpEntrega')->comment('Tipo da entrega');
            $table->string('statusPedido')->comment('Status do pedido');
            $table->dateTime('dtPedido')->nullable()->comment('Data do pedido');
            $table->dateTime('dtFaturamento')->nullable()->comment('Data do faturamento');
            $table->dateTime('dtEntrega')->nullable()->comment('Data da entrega');
            $table->decimal('vrTotal', $precision = 15, $scale = 2)->nullable()->comment('Valor total');
            $table->string('numOrdemCompra')->nullable()->comment('Ordem de compra');
            $table->string('nmArquivo')->nullable()->comment('Arquivo de detalhes do pedido');

            $table->timestamps();
            $table->softDeletes();

            // Indexes da tabela
            $table->foreign('idCliente')->references('idCliente')->on('customers')->onDelete('cascade');
            $table->foreign('idFilial')->references('idFilial')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
