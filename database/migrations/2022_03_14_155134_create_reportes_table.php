<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehiculos_id')->nullable();
            $table->time('hora_t');
            $table->date('fecha_t');
            $table->date('fecha');
            $table->string('detalle')->nullable();
            $table->boolean('estado')->default(true);
            $table->unsignedBigInteger('empresa_id');
            $table->boolean('eliminado')->default(false);
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('vehiculos_id')->references('id')->on('vehiculos')->onDelete('set null');
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
        Schema::dropIfExists('reportes');
    }
}
