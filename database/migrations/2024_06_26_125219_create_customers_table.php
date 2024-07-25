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
        Schema::create('customers', function (Blueprint $table) {
            // Campos da tabela
            $table->id('idCliente')->comment('Chave primária da tabela');

            $table->string('extCliente')->comment('Código externo do cliente');
            $table->string('nmCliente')->comment('Nome do cliente');
            $table->enum('tpCliente', ['F', 'J'])->comment('Tipo do cliente');
            $table->string('emailCliente')->comment('Email do cliente cadastrado');
            $table->string('codCliente')->comment('CPF/CNPJ do cliente');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
