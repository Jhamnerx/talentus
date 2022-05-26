<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_contratos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehiculos_id');
            $table->unsignedBigInteger('contratos_id');
            $table->string('plan');

            $table->foreign('vehiculos_id')->references('id')->on('vehiculos')->onDelete('cascade');
            $table->foreign('contratos_id')->references('id')->on('contratos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_contratos');
    }
}
