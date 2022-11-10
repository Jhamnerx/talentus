<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function PHPUnit\Framework\once;

class CreateActasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehiculos_id')->nullable();
            $table->string('numero');
            $table->date('inicio_cobertura')->nullable();
            $table->date('fin_cobertura')->nullable();
            $table->string('fecha')->nullable();
            $table->year('year')->nullable();
            $table->boolean('sello')->default(1);
            $table->boolean('fondo')->default(1);
            $table->string('plataforma')->nullable();
            $table->boolean('estado')->default(true);
            $table->string('codigo')->nullable();
            $table->string('unique_hash')->nullable();

            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->unsignedBigInteger('ciudades_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('vehiculos_id')->references('id')->on('vehiculos')->onDelete('cascade');
            $table->foreign('ciudades_id')->references('id')->on('ciudades')->onDelete('set null');
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
        Schema::dropIfExists('actas');
    }
}
