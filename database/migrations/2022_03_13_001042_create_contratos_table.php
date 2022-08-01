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
            $table->unsignedBigInteger('clientes_id')->nullable();
            $table->date('fecha');
            $table->boolean('sello')->default(true);
            $table->boolean('fondo')->default(true);
            $table->boolean('estado')->default(true);
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('ciudades_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('eliminado')->default(false);
            $table->string('unique_hash')->nullable();

            $table->foreign('ciudades_id')->references('id')->on('ciudades')->onDelete('set null');
            $table->foreign('clientes_id')->references('id')->on('clientes')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
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
