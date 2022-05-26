<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('clientes_id');
            $table->date('fecha');
            $table->boolean('sello')->default(true);
            $table->boolean('fondo')->default(true);
            $table->boolean('estado')->default(true);
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('ciudades_id');
            $table->boolean('is_active')->default(true);
            $table->boolean('eliminado')->default(false);

            $table->foreign('ciudades_id')->references('id')->on('ciudades')->onDelete('cascade');
            $table->foreign('clientes_id')->references('id')->on('clientes')->onDelete('cascade');

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
        Schema::dropIfExists('contratos');
    }
}
