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
        Schema::create('users_has_organizations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('get_user_id')->comment('Foreign key para a tabela users');
            $table->unsignedBigInteger('get_organization_id')->comment('Foreign key para a tabela organizations');
            $table->timestamps();
            $table->foreign('get_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('get_organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_has_organizations');
    }
};
