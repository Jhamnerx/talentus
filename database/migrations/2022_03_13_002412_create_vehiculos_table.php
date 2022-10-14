<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('placa');
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('tipo')->nullable();
            $table->string('year')->nullable();
            $table->string('color')->nullable();
            $table->string('motor')->nullable();
            $table->string('serie')->nullable();
            $table->string('dispositivo_imei')->nullable();
            $table->unsignedBigInteger('sim_card_id')->nullable();
            $table->string('numero')->unique()->nullable();
            $table->string('old_numero')->nullable();
            $table->string('old_sim_card')->nullable();
            $table->unsignedBigInteger('flotas_id')->nullable();
            $table->unsignedBigInteger('dispositivos_id')->nullable();
            $table->unsignedBigInteger('empresa_id');
            $table->enum('estado', [1, 2])->default(1);
            $table->boolean('is_active')->default(true);

            $table->foreign('flotas_id')->references('id')->on('flotas')->onDelete('set null');
            $table->foreign('dispositivos_id')->references('id')->on('dispositivos')->onDelete('set null');
            $table->foreign('sim_card_id')->references('id')->on('sim_card')->onDelete('set null');

            $table->softDeletes();
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
        Schema::dropIfExists('vehiculos');
    }
}
