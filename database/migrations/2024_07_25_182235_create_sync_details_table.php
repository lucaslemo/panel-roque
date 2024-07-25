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
        Schema::create('sync_details', function (Blueprint $table) {
            $table->id('idDetalheSincronizacao')->comment('Chave primária da tabela');
            $table->unsignedBigInteger('idSincronizacao')->nullable()->comment('Foreign key para a tabela clientes');

            $table->string('nmEntidade')->comment('Nome da entidade que foi atualizada');
            $table->integer('numDadosAtualizados')->default(0)->comment('Quantidade de dados que já foram processados');
            $table->integer('numDadosAtualizar')->nullable()->comment('Quantidade de dados que faltam processar');

            $table->timestamps();
            $table->softDeletes();

            // Indexes da tabela
            $table->foreign('idSincronizacao')->references('idSincronizacao')->on('syncs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sync_details');
    }
};
