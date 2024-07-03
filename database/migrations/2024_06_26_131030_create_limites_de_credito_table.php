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
        Schema::create('limitesDeCredito', function (Blueprint $table) {
            // Campos da tabela
            $table->id('idLimiteDeCredito')->comment('Chave primária da tabela');
            $table->unsignedBigInteger('idCliente')->comment('Foreign key para a tabela clientes');

            $table->decimal('vrLimite', $precision = 15, $scale = 2)->comment('Valor limite de credito');
            $table->decimal('vrUtilizado', $precision = 15, $scale = 2)->comment('Valor usado do limite');
            $table->decimal('vrReservado', $precision = 15, $scale = 2)->comment('Valor reservado');
            $table->decimal('vrDisponivel', $precision = 15, $scale = 2)->comment('Valor disponível');

            $table->timestamps();
            $table->softDeletes();

            // Indexes da tabela
            $table->foreign('idCliente')->references('idCliente')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('limitesDeCredito');
    }
};
