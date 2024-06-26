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
        Schema::create('credit_limits', function (Blueprint $table) {
            $table->id();
            $table->decimal('limit', $precision = 15, $scale = 2)->comment('Valor limite de credito');
            $table->decimal('used', $precision = 15, $scale = 2)->comment('Valor usado do limite');
            $table->decimal('reserved', $precision = 15, $scale = 2)->comment('Valor reservado');
            $table->decimal('available', $precision = 15, $scale = 2)->comment('Valor disponivel');
            $table->unsignedBigInteger('get_organization_id')->comment('Foreign key para a tabela organizations');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('get_organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_limits');
    }
};
