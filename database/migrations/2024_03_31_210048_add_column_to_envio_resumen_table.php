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
        Schema::table('envio_resumen', function (Blueprint $table) {
            //
            $table->dateTime('fecha_generacion')->nullable()->after('user_id');
            $table->dateTime('fecha_envio')->nullable()->after('fecha_generacion');


            //SUNAT RESPUESTA
            $table->text('estado_texto')->nullable()->after('nombre_xml');
            $table->text('fe_mensaje_error')->nullable()->after('nombre_xml');
            $table->text('nota')->nullable()->after('nombre_xml');
            $table->text('xml_base64')->nullable()->after('nombre_xml');
            $table->text('cdr_base64')->nullable()->after('nombre_xml');
            $table->text('hash')->nullable()->after('nombre_xml');
            $table->text('hash_cdr')->nullable()->after('nombre_xml');
            $table->text('code_sunat')->nullable()->after('nombre_xml');
            $table->longText('clase')->nullable()->after('nombre_xml');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('envio_resumen', function (Blueprint $table) {
            //
        });
    }
};
