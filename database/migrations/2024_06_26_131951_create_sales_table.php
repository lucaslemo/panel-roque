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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('branch')->comment('Filial');
            $table->string('delivery_type')->comment('Tipo de entrega');
            $table->dateTime('order_date')->comment('Data do pedido');
            $table->string('rca')->nullable()->comment('RCA');
            $table->dateTime('billing_date')->nullable()->comment('Data do faturamento');
            $table->decimal('value', $precision = 15, $scale = 2)->comment('Valor');
            $table->string('cob')->nullable()->comment('COB');
            $table->string('status')->comment('Status');
            $table->dateTime('delivery_date')->nullable()->comment('Data da entrega');
            $table->string('type')->comment('Tipo');
            $table->string('delivery_status')->nullable()->comment('Status da entrega');
            $table->dateTime('creation_date')->comment('Data de criacao');
            $table->string('purchase_order')->nullable()->comment('Ordem de compra');
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
        Schema::dropIfExists('sales');
    }
};
