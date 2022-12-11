<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispositivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispositivos', function (Blueprint $table) {

            $table->id();
            $table->string('imei')->unique();
            $table->unsignedBigInteger('modelo_id')->nullable();
            $table->boolean('of_client')->default(false);
            $table->unsignedBigInteger('empresa_id');
            $table->enum('estado', ['VENDIDO', 'STOCK'])->default('STOCK');

            $table->foreign('modelo_id')->references('id')->on('modelos_dispositivos')->onDelete('set null');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
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
        Schema::dropIfExists('dispositivos');
    }
}
