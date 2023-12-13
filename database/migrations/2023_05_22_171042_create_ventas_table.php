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

        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_comprobante_id');
            $table->foreign('tipo_comprobante_id')->references('codigo')->on('tipo_comprobantes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('serie');
            $table->string('correlativo');
            $table->string('serie_correlativo');
            $table->foreignId('cliente_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('fecha_emision');
            $table->dateTime('fecha_hora_emision');
            $table->date('fecha_vencimiento');
            $table->string('divisa')->nullable();
            $table->decimal('tipo_cambio', 11, 2)->nullable();
            $table->string('metodo_pago_id');
            $table->foreign('metodo_pago_id')->references('codigo')->on('metodo_pago')->onDelete('cascade')->onUpdate('cascade');
            $table->text('comentario')->nullable();
            $table->decimal('op_gravadas', 11, 2)->nullable();
            $table->decimal('op_exoneradas', 11, 2)->nullable();
            $table->decimal('op_inafectas', 11, 2)->nullable();
            $table->decimal('op_gratuitas', 11, 2)->nullable();
            $table->decimal('igv_op', 11, 2)->default(0.00);
            $table->decimal('descuento', 11, 2);
            $table->string('tipo_descuento')->nullable();
            $table->decimal('descuento_factor', 11, 5)->nullable();
            $table->decimal('icbper', 11, 4)->nullable();
            $table->decimal('sub_total', 11, 4)->default(0.00);
            $table->decimal('igv', 11, 4)->nullable();
            $table->decimal('adelanto', 15, 4)->default(0.00);
            $table->decimal('total', 11, 4)->default(0.00);
            $table->string('numero_cuotas')->nullable();
            $table->string('vence_cuotas')->nullable();
            $table->text('detalle_cuotas')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('anulado', ["si", "no"])->default('no');
            $table->enum('resumen', ["si", "no"])->default('no');
            $table->enum('estado', ["COMPLETADO", "BORRADOR"])->default('BORRADOR');
            $table->enum('pago_estado', ["UNPAID", "PAID"])->default('UNPAID');
            $table->enum('forma_pago', ["CONTADO", "CREDITO"])->default('CONTADO');
            //SUNAT RESPUESTA
            $table->boolean('fe_estado')->default(false);
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
            $table->string('id_baja')->nullable();
            $table->foreignId('nota_credito_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('nota_debito_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('bienes_selva')->default(false);
            $table->boolean('servicios_selva')->default(false);
            $table->boolean('viewed')->default(false);
            $table->boolean('sent')->default(false);
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
        Schema::dropIfExists('ventas');
    }
};
