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
        Schema::create('users_has_customers', function (Blueprint $table) {
            // Campos da tabela
            $table->unsignedBigInteger('idUsuario')->comment('Foreign key para a tabela users');
            $table->unsignedBigInteger('idCliente')->comment('Foreign key para a tabela clientes');

            $table->timestamps();

            // Indexes da tabela
            $table->primary(['idUsuario', 'idCliente']);
            $table->foreign('idUsuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idCliente')->references('idCliente')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_has_customers');
    }
};
