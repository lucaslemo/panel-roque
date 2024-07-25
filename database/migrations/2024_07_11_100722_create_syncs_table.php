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
        Schema::create('syncs', function (Blueprint $table) {
            // Campos da tabela
            $table->id('idSincronizacao')->comment('Chave primária da tabela');

            $table->dateTime('dtFinalBusca')->nullable()->comment('Data em que termina a última chamada para da api');
            $table->dateTime('dtSincronizacao')->nullable()->comment('Data em que os dados foram sincronizados');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syncs');
    }
};
