<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificados', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->date('fin_cobertura');
            $table->string('fecha');
            $table->string('year');
            $table->boolean('sello')->default(1);
            $table->boolean('fondo')->default(1);
            $table->boolean('estado')->default(true);
            $table->boolean('eliminado')->default(false);
            $table->unsignedBigInteger('clientes_id');
            $table->unsignedBigInteger('ciudades_id');
            $table->unsignedBigInteger('dispositivos_id');
            $table->unsignedBigInteger('empresa_id');

            $table->foreign('clientes_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('ciudades_id')->references('id')->on('ciudades')->onDelete('cascade');
            $table->foreign('dispositivos_id')->references('id')->on('dispositivos')->onDelete('cascade');

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
        Schema::dropIfExists('certificados');
    }
}
