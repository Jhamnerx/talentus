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
        Schema::create('comprobantes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_comprobante_id');
            $table->foreign('tipo_comprobante_id')->references('codigo')->on('tipo_comprobantes')->onDelete('cascade')->onUpdate('cascade');
            $table->text('serie');
            $table->string('correlativo');
            $table->string('serie_correlativo');
            $table->date('fecha_emision');
            $table->dateTime('fecha_hora_emision')->nullable();
            $table->string('divisa');
            $table->decimal('tipo_cambio', 11, 2)->nullable();
            $table->decimal('op_gravadas', 11, 2)->nullable();
            $table->decimal('op_exoneradas', 11, 2)->nullable();
            $table->decimal('op_inafectas', 11, 2)->nullable();
            $table->decimal('op_gratuitas', 11, 2)->nullable();
            $table->decimal('descuento', 11, 2)->nullable();
            $table->decimal('sub_total', 11, 4)->default(0.00);
            $table->decimal('icbper', 11, 4)->nullable();
            $table->decimal('igv', 11, 4)->nullable();
            $table->decimal('total', 11, 4)->default(0.00);
            $table->foreignId('cliente_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('tipo_comprobante_ref')->nullable();
            $table->string('serie_ref')->nullable();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('invoice_id_new')->nullable();
            $table->foreign('invoice_id')->references('id')->on('ventas')->onDelete('set null');
            $table->foreign('invoice_id_new')->references('id')->on('ventas')->onDelete('set null');
            $table->string('correlativo_ref')->nullable();
            $table->string('serie_correlativo_ref')->nullable();
            $table->foreignId('sustento_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('sustento_texto')->nullable();
            //SUNAT RESPUESTA
            $table->boolean('fe_estado')->default(false);
            $table->text('estado_texto')->nullable();
            $table->text('fe_codigo_error')->nullable();
            $table->text('fe_mensaje_error')->nullable();
            $table->text('fe_mensaje_sunat')->nullable();
            $table->text('nota')->nullable();
            $table->text('nombre_xml')->nullable();
            $table->text('xml_base64')->nullable();
            $table->text('cdr_base64')->nullable();
            $table->text('hash')->nullable();
            $table->text('hash_cdr')->nullable();
            $table->text('code_sunat')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprobantes');
    }
};
