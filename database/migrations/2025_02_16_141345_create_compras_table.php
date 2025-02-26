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
        Schema::create('compras', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('proveedor_id');
            $table->string('serie');
            $table->string('correlativo');
            $table->string('serie_correlativo')->nullable();
            $table->date('fecha_emision');
            $table->string('divisa')->nullable();
            $table->text('comentario')->nullable();
            $table->decimal('sub_total', 11, 4)->default(0);
            $table->decimal('igv', 11, 4)->nullable();
            $table->decimal('total', 11, 4)->default(0);

            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('estado', ['COMPLETADO', 'BORRADOR', 'ANULADO'])->default('BORRADOR');
            $table->enum('pago_estado', ['UNPAID', 'PAID'])->default('UNPAID');
            $table->enum('forma_pago', ['CONTADO', 'CREDITO'])->default('CONTADO');
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign(['empresa_id'])->references(['id'])->on('empresas')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
