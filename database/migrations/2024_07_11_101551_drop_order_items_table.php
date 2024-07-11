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
        Schema::dropIfExists('order_items');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                // Campos da tabela
                $table->id('idPedidoItem')->comment('Chave primária da tabela');
                $table->unsignedBigInteger('idPedidoCabecalho')->comment('Foreign key para a tabela pedidos cabeçalho');
    
                $table->string('nmDetalhe')->comment('Detalhe do pedido');
                $table->string('tpQuantidade')->comment('Tipo da quantidade');
                $table->bigInteger('numQuantidade')->comment('Quantidade do item');
                $table->decimal('vrUnitario', $precision = 15, $scale = 2)->comment('Valor unitário');
                $table->decimal('vrPeso', $precision = 8, $scale = 2)->comment('Peso total');
    
                $table->timestamps();
                $table->softDeletes();
    
                // Indexes da tabela
                $table->foreign('idPedidoCabecalho')->references('idPedidoCabecalho')->on('pedidosCabecalhos')->onDelete('cascade');
            });
       }
    }
};
