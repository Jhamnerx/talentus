<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //ESTA TABLA TENDRA LOS REGISTROS DE LOS DISPOSITIVOS INSTALADOS EN LOS VEHICULOS
    //PUEDEN SER MULTIPLES DISPOSITIVOS POR VEHICULO
    //SE DEBE PODER REGISTRAR LA FECHA DE INSTALACION Y DESINSTALACION
    //SE DEBE PODER REGISTRAR EL NUMERO DE SERIE DEL DISPOSITIVO
    public function up(): void
    {
        Schema::create('vehiculos_dispositivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehiculo_id')->nullable();
            $table->text('imei')->nullable();
            $table->date('fecha_instalacion')->nullable();
            $table->date('fecha_desinstalacion')->nullable();
            $table->string('hash')->nullable();
            $table->unsignedBigInteger('dispositivo_id')->nullable();
            $table->boolean('is_principal')->default(false); // Indica si es el principal

            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('cascade');
            $table->foreign('dispositivo_id')->references('id')->on('dispositivos')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos_dispositivos');
    }
};
