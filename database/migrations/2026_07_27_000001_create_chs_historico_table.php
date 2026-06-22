<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chs_historico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('cliente_id');
            $table->date('periodo');
            $table->unsignedTinyInteger('score_final');
            $table->string('categoria');
            $table->json('factores_detalle');
            $table->timestamps();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->unique(['cliente_id', 'periodo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chs_historico');
    }
};
