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
        Schema::create('invoices', function (Blueprint $table) {
            // Campos da tabela
            $table->id('idConta')->comment('Chave primária da tabela');
            $table->unsignedBigInteger('idCliente')->nullable()->comment('Foreign key para a tabela clientes');
            $table->unsignedBigInteger('idPedidoCabecalho')->nullable()->comment('Foreign key para a tabela pedidos cabeçalhos');
            $table->unsignedBigInteger('idFilial')->nullable()->comment('Foreign key para a tabela filiais');

            $table->string('extCliente')->comment('Código externo do cliente');
            $table->string('extConta')->comment('Código externo da conta');
            $table->string('extPedido')->nullable()->comment('Código externo do pedido');
            $table->string('nmVendedor')->nullable()->comment('Nome do vendedor');
            $table->string('statusConta')->comment('Status da conta');
            $table->string('nmSituacao')->nullable()->comment('Situação da conta');
            $table->string('tpCobranca')->nullable()->comment('Tipo de cobrança');
            $table->date('dtParcela')->comment('Data da parcela');
            $table->integer('numDuplicata')->nullable()->comment('Número da duplicata');
            $table->integer('numParcela')->nullable()->comment('Número da parcela');
            $table->integer('numTotalParcela')->nullable()->comment('Número total de parcelas');
            $table->date('dtEmissao')->comment('Data da emissão');
            $table->date('dtVencimento')->comment('Data de vencimento');
            $table->date('dtPagamento')->nullable()->comment('Data do pagamento');
            $table->decimal('vrBruto', $precision = 15, $scale = 2)->comment('Total bruto');
            $table->decimal('vrLiquido', $precision = 15, $scale = 2)->nullable()->comment('Total liquido');
            $table->decimal('vrAtualizado', $precision = 15, $scale = 2)->nullable()->comment('Total atualizado');
            $table->decimal('vrPago', $precision = 15, $scale = 2)->nullable()->comment('Valor pago');
            $table->boolean('isBoleto')->default(false)->comment('Se a conta é boleto ou não');
            $table->string('nmArquivoConta')->nullable()->comment('Arquivo da conta');

            $table->timestamps();
            $table->softDeletes();

            // Indexes da tabela
            $table->foreign('idCliente')->references('idCliente')->on('customers')->onDelete('cascade');
            $table->foreign('idPedidoCabecalho')->references('idPedidoCabecalho')->on('orders')->onDelete('cascade');
            $table->foreign('idFilial')->references('idFilial')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
