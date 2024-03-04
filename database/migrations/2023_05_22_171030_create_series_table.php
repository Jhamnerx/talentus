<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_comprobante_id');
            $table->foreign('tipo_comprobante_id')->references('codigo')->on('tipo_comprobantes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('serie')->nullable();
            $table->string('correlativo');
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
