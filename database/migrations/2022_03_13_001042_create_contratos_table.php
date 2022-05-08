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
            $table->enum('sello', [0, 1])->default(1);
            $table->enum('fondo', [0, 1])->default(1);
            $table->enum('estado', [0, 1])->default(1);
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
        Schema::dropIfExists('contratos');
    }
}
