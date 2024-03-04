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
        Schema::create('detalles_cobros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cobros_id')->nullable();
            $table->unsignedBigInteger('vehiculo_id')->nullable();
            $table->string('plan');
            $table->date('fecha');




            $table->foreign('cobros_id')->references('id')->on('cobros')->onDelete('set null');
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_cobros');
    }
};
