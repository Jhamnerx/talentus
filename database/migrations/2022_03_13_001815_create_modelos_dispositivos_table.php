<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelosDispositivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modelos_dispositivos', function (Blueprint $table) {
            $table->id();
            $table->string('modelo');
            $table->string('marca')->nullable();
            $table->string('certificado')->nullable();
            $table->text('caracteristicas')->nullable();
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
        Schema::dropIfExists('modelos_dispositivos');
    }
}
