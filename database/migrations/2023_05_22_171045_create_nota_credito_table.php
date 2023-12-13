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

        Schema::create('nota_credito', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_comprobante_id');
            $table->foreign('tipo_comprobante_id')->references('codigo')->on('tipo_comprobante')->onDelete('cascade')->onUpdate('cascade');
            $table->text('serie');
            $table->string('correlativo');
            $table->date('fecha_emision');
            $table->string('divisa');
            $table->decimal('tipo_cambio', 11, 2)->nullable();
            $table->decimal('op_gravadas', 11, 2)->nullable();
            $table->decimal('op_exoneradas', 11, 2)->nullable();
            $table->decimal('op_inafectas', 11, 2)->nullable();
            $table->decimal('op_gratuitas', 11, 2)->nullable();
            $table->decimal('descuento', 11, 2)->nullable();
            $table->decimal('igv', 11, 2)->nullable();
            $table->decimal('total', 11, 2)->nullable();
            $table->foreignId('cliente_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('tipo_comprobante_ref')->nullable();
            $table->string('serie_ref')->nullable();
            $table->string('correlativo_ref')->nullable();
            $table->string('serie_correlativo_ref')->nullable();
            $table->foreignId('sustento_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('fe_estado')->default(false);
            $table->string('fe_codigo_error')->nullable();
            $table->text('fe_mensaje_sunat')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('nota_creditos');
    }
};
