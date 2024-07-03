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
        Schema::create('contas', function (Blueprint $table) {
            // Campos da tabela
            $table->id('idConta')->comment('Chave primária da tabela');
            $table->unsignedBigInteger('idCliente')->comment('Foreign key para a tabela clientes');
            $table->unsignedBigInteger('idPedidoCabecalho')->nullable()->comment('Foreign key para a tabela pedidos cabeçalhos');
            $table->unsignedBigInteger('idFilial')->comment('Foreign key para a tabela filiais');
            $table->unsignedBigInteger('idRCA')->nullable()->comment('Foreign key para a tabela RCA');

            $table->string('statusConta')->comment('Status da conta');
            $table->string('nmSituacao')->comment('Situação da conta');
            $table->enum('tpCobranca', ['CHE', 'CCR', 'DIN'])->nullable()->comment('Tipo de cobrança');
            $table->date('dtParcela')->comment('Data da parcela');
            $table->integer('numDuplicado')->comment('Duplicado');
            $table->date('dtEmissao')->comment('Data da emissão');
            $table->date('dtVencimento')->comment('Data de vencimento');
            $table->date('dtPagamento')->nullable()->comment('Data do pagamento');
            $table->decimal('vrBruto', $precision = 15, $scale = 2)->comment('Total bruto');
            $table->decimal('vrLiquido', $precision = 15, $scale = 2)->comment('Total liquido');
            $table->decimal('vrAtualizado', $precision = 15, $scale = 2)->comment('Total atualizado');
            $table->decimal('vrPago', $precision = 15, $scale = 2)->nullable()->comment('Valor pago');
            $table->bigInteger('numCheque')->comment('Número do Cheque');

            $table->timestamps();
            $table->softDeletes();

            // Indexes da tabela
            $table->foreign('idCliente')->references('idCliente')->on('clientes')->onDelete('cascade');
            $table->foreign('idPedidoCabecalho')->references('idPedidoCabecalho')->on('pedidosCabecalhos')->onDelete('cascade');
            $table->foreign('idFilial')->references('idFilial')->on('filiais')->onDelete('cascade');
            $table->foreign('idRCA')->references('idRCA')->on('representantesComerciaisAutonomos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contas');
    }
};
