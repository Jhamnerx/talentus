<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clientes_id');
            $table->string('numero')->nullable();
            $table->date('fecha');
            $table->date('fecha_caducidad');
            $table->string('divisa')->default('PEN');
            $table->enum('estado', [0, 1, 2])->default(0);
            $table->string('nota')->nullable();
            $table->unsignedBigInteger('empresa_id');
            $table->boolean('is_active')->default(true);
            $table->boolean('eliminado')->default(false);


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
        Schema::dropIfExists('presupuestos');
    }
}
