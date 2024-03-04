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
        Schema::disableForeignKeyConstraints();

        Schema::create('nota_credito_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nota_credito_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('producto_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('cantidad');
            $table->decimal('valor_unitario', 11, 2)->nullable();
            $table->decimal('precio_unitario', 11, 2)->nullable();
            $table->decimal('igv', 11, 2)->nullable();
            $table->decimal('porcentaje_igv', 11, 2)->nullable();
            $table->decimal('descuento', 11, 2)->nullable();
            $table->decimal('valor_total', 11, 2)->nullable();
            $table->decimal('importe_total', 11, 2)->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_credito_detalles');
    }
};
