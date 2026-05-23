<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guia_remision', function (Blueprint $table) {
            $table->unsignedBigInteger('driver_id')->nullable()->after('user_id');
            $table->unsignedBigInteger('transport_id')->nullable()->after('driver_id');
            $table->unsignedBigInteger('dispatcher_id')->nullable()->after('transport_id');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('set null');
            $table->foreign('transport_id')->references('id')->on('transports')->onDelete('set null');
            $table->foreign('dispatcher_id')->references('id')->on('dispatchers')->onDelete('set null');

            $table->string('chofer_nombre')->nullable()->after('numero_doc_chofer');
            $table->string('chofer_apellidos')->nullable()->after('chofer_nombre');
            $table->string('chofer_licencia')->nullable()->after('chofer_apellidos');
            $table->string('transp_address')->nullable()->after('transp_razon_social');
            $table->string('transp_numero_mtc')->nullable()->after('transp_address');
            $table->string('placa_semirremolque')->nullable()->after('transp_placa');
            $table->date('fecha_entrega_transportista')->nullable()->after('fecha_inicio_traslado');
            $table->boolean('is_transport_m1l')->default(false)->after('fecha_entrega_transportista');
            $table->boolean('has_transport_driver_01')->default(false)->after('is_transport_m1l');
        });
    }

    public function down(): void
    {
        Schema::table('guia_remision', function (Blueprint $table) {
            $table->dropForeign(['driver_id', 'transport_id', 'dispatcher_id']);
            $table->dropColumn([
                'driver_id',
                'transport_id',
                'dispatcher_id',
                'chofer_nombre',
                'chofer_apellidos',
                'chofer_licencia',
                'transp_address',
                'transp_numero_mtc',
                'placa_semirremolque',
                'fecha_entrega_transportista',
                'is_transport_m1l',
                'has_transport_driver_01',
            ]);
        });
    }
};
