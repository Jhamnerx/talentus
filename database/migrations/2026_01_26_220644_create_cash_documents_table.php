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
        Schema::create('cash_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cash_id');

            // Documentos - solo uno será usado a la vez (nullable porque es opcional)
            $table->unsignedBigInteger('factura_id')->nullable();
            $table->unsignedBigInteger('recibo_id')->nullable();
            $table->unsignedBigInteger('venta_id')->nullable();
            $table->unsignedBigInteger('expense_payment_id')->nullable();
            $table->unsignedBigInteger('compra_id')->nullable();
            $table->unsignedBigInteger('cotizacion_id')->nullable();
            $table->unsignedBigInteger('orden_trabajo_id')->nullable();

            // Foreign keys
            $table->foreign('cash_id')->references('id')->on('cash')->onDelete('cascade');

            // Indexes para búsquedas rápidas
            $table->index('cash_id');
            $table->index('factura_id');
            $table->index('recibo_id');
            $table->index('venta_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_documents');
    }
};
