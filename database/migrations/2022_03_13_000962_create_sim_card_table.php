<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sim_card', function (Blueprint $table) {
            $table->id();
            $table->string('sim_card')->nullable()->unique();
            $table->unsignedBigInteger('lineas_id')->nullable();
            $table->string('operador');
            $table->unsignedBigInteger('empresa_id');
            $table->enum('estado', [1, 2])->default(1);
            $table->timestamps();

            $table->foreign('lineas_id')->references('id')->on('lineas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sim_card');
    }
}
