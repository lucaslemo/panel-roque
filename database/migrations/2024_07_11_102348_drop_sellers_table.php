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
        Schema::dropIfExists('sellers');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('sellers')) {
            Schema::create('sellers', function (Blueprint $table) {
                // Campos da tabela
                $table->id('idRCA')->comment('Chave primária da tabela');

                $table->string('nmRCA')->comment('Nome do representante comercial autônomo');

                $table->timestamps();
                $table->softDeletes();
            });
        }
    }
};
