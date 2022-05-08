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
            $table->unsignedBigInteger('empresas_id');
            $table->string('razon_social');
            $table->string('ruc');
            $table->integer('impuesto');
            $table->string('img_logo');
            $table->string('img_icono');
            $table->string('img_login');
            $table->string('img_contrato');
            $table->string('img_acta');
            $table->string('img_certificado');
            $table->string('img_firma');

            $table->foreign('empresas_id')->references('id')->on('empresas')->onUpdate('cascade');

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
