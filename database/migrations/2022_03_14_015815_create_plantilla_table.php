<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantillaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantilla', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id');
            $table->string('razon_social');
            $table->string('ruc');
            $table->integer('impuesto');
            $table->string('fondo_contrato');
            $table->string('img_documentos');
            $table->string('logo');
            $table->string('banner');
            $table->string('img_firma');
            $table->string('fav_icon');
            $table->text('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->text('sunat')->nullable();
            $table->string('correo')->nullable();
            $table->text('series');

            $table->foreign('empresa_id')->references('id')->on('empresas')->onUpdate('cascade');

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
        Schema::dropIfExists('plantilla');
    }
}
