<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->text('numero');
            $table->text('detalle_trabajo')->nullable();
            $table->dateTime('fecha_hora_mantenimiento');
            $table->boolean('notify_admin')->default(true);
            $table->boolean('notify_client')->default(false);
            $table->text('nota')->nullable();
            $table->enum('estado', ['PENDIENTE', 'COMPLETADA', 'CANCELADO'])->default('PENDIENTE');
            $table->unsignedBigInteger('vehiculo_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('cascade');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');
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
        Schema::dropIfExists('mantenimiento');
    }
};
