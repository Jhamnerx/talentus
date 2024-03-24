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

        Schema::create('envio_resumen_detalle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('envio_resumen_id')->nullable()->unsigned();
            $table->foreign('envio_resumen_id')->references('id')->on('envio_resumen')->onDelete('cascade');
            $table->foreignId('venta_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('condicion')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envio_resumen_detalles');
    }
};
