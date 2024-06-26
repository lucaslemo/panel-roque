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
        Schema::create('bills_to_receive', function (Blueprint $table) {
            $table->id();
            $table->string('branch')->comment('Filial');
            $table->string('cob')->nullable()->comment('COB');
            $table->integer('duplicate')->nullable()->comment('Duplicado');
            $table->date('portion_date')->comment('Data da parcela');
            $table->decimal('total_gross', $precision = 15, $scale = 2)->comment('Total bruto');
            $table->bigInteger('ref')->comment('Referencia do pedido');
            $table->date('emission_date')->comment('Data da emissao');
            $table->date('expiry_date')->comment('Data de vencimento');
            $table->date('payment_date')->nullable()->comment('Data do pagamento');
            $table->string('status')->comment('Status');
            $table->string('situation')->comment('Situação');
            $table->decimal('net_total', $precision = 15, $scale = 2)->comment('Total liquido');
            $table->decimal('updated_total', $precision = 15, $scale = 2)->comment('Total atualizado');
            $table->decimal('amount_paid', $precision = 15, $scale = 2)->nullable()->comment('Valor pago');
            $table->string('rca')->nullable()->comment('RCA');
            $table->bigInteger('check')->nullable()->comment('Cheque');
            $table->unsignedBigInteger('get_organization_id')->nullable()->comment('Foreign key para a tabela organizations');
            $table->unsignedBigInteger('get_sale_id')->nullable()->comment('Foreign key para a tabela sales');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('get_organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('get_sale_id')->references('id')->on('sales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills_to_receive');
    }
};
