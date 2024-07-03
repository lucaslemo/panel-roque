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
        Schema::create('clientes', function (Blueprint $table) {
            // Campos da tabela
            $table->id('idCliente')->comment('Chave primária da tabela');

            $table->string('nmCliente')->comment('Nome do cliente');
            $table->enum('tpCliente', ['Pessoa Física', 'Pessoa Jurídica'])->comment('Tipo do cliente');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
