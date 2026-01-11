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
        Schema::create('tipo_cambios', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->unique()->comment('Fecha del tipo de cambio');
            $table->decimal('compra', 10, 3)->comment('Tipo de cambio de compra');
            $table->decimal('venta', 10, 3)->comment('Tipo de cambio de venta');
            $table->string('fuente')->default('factiliza')->comment('Fuente de la consulta');
            $table->timestamps();

            $table->index('fecha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_cambios');
    }
};
