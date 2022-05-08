<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCambiosLineasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cambios_lineas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_cambio');
            $table->unsignedBigInteger('sim_card_id')->nullable();
            $table->string('old_sim_card')->nullable();
            $table->unsignedBigInteger('old_numero')->nullable();
            $table->unsignedBigInteger('new_numero')->nullable();
            $table->date('fecha_suspencion')->nullable();
            $table->date('fecha_suspencion_fin')->nullable();
            $table->unsignedBigInteger('user_id');
            //$table->unsignedBigInteger('lineas_id');


            $table->foreign('sim_card_id')->references('id')->on('sim_card')->onDelete('cascade');
            $table->foreign('old_numero')->references('id')->on('lineas')->onDelete('cascade');
            $table->foreign('new_numero')->references('id')->on('lineas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


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
        Schema::dropIfExists('cambios_lineas');
    }
}
