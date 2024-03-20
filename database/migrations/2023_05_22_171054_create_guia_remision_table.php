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
        Schema::dropIfExists('guia_remision');
        Schema::create('guia_remision', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('serie');
            $table->string('correlativo');
            $table->string('serie_correlativo');
            $table->date('fecha_emision');

            $table->foreignId('venta_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('terceros_tipo_documento')->nullable();
            $table->string('terceros_num_doc')->nullable();
            $table->text('terceros_razon_social')->nullable();
            $table->string('codigo_traslado')->nullable();
            $table->string('motivo_traslado_id')->nullable();
            $table->foreign('motivo_traslado_id')->references('codigo')->on('motivo_traslado')->onDelete('cascade')->onUpdate('cascade');
            $table->text('descripcion_motivo_traslado')->nullable();
            $table->string('modalidad_transporte_id')->nullable();
            $table->foreign('modalidad_transporte_id', 'fk_guia_modalidad_t')->references('codigo')->on('modalidad_transporte')->onDelete('cascade')->onUpdate('cascade');
            $table->date('fecha_inicio_traslado')->nullable();
            $table->string('transp_tipo_doc')->nullable();
            $table->string('transp_numero_doc')->nullable();
            $table->text('transp_razon_social')->nullable();
            $table->string('transp_placa')->nullable();
            $table->string('tipo_doc_chofer')->nullable();
            $table->string('numero_doc_chofer')->nullable();
            $table->string('peso')->nullable();
            $table->string('cantidad_items')->nullable();
            $table->string('numero_contenedor')->nullable();
            $table->text('datos_puerto')->nullable();
            $table->text('direccion_partida')->nullable();
            $table->string('ubigeo_partida')->nullable();
            $table->text('direccion_llegada')->nullable();
            $table->string('ubigeo_llegada')->nullable();
            $table->string('codigo_establecimiento_llegada')->nullable();
            $table->string('codigo_establecimiento_partida')->nullable();


            $table->string('docu_rel_tipo')->nullable();
            $table->string('docu_rel_numero')->nullable();

            $table->text('observacion')->nullable();
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
            $table->longText('clase')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->unsignedBigInteger('tecnico_id')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');
            $table->foreign('tecnico_id')->references('id')->on('users')->onDelete('set null');

            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guia_remision');
    }
};
