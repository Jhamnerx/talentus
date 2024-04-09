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
        Schema::create('detracciones', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_detraccion')->nullable();
            $table->foreign('codigo_detraccion')->references('codigo')->on('codigos_detracciones')->onDelete('set null')->onUpdate('cascade');
            $table->decimal('porcentaje', 12, 2);
            $table->decimal('monto', 12, 2);
            $table->decimal('tipo_cambio', 12, 4);
            $table->string('metodo_pago_id')->nullable();
            $table->foreign('metodo_pago_id')->references('codigo')->on('metodo_pago')->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('venta_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('cuenta_bancaria')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detracciones');
    }
};
