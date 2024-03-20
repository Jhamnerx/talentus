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
        Schema::table('plantilla', function (Blueprint $table) {
            $table->string('tipo_documento')->nullable(); //6
            $table->text('nombre_comercial')->nullable();
            $table->string('pais')->nullable();
            $table->text('sunat_datos')->nullable();
            $table->enum('modo', ["produccion", "local"])->default('local');
            $table->boolean('afecto_igv')->default(true);
            $table->text('mail_config')->nullable();
            $table->boolean('bienes_selva')->default(false);
            $table->boolean('servicios_selva')->default(false);
            $table->string('ruta_xml')->nullable();
            $table->string('ruta_cdr')->nullable();
            $table->string('ruta_cert')->nullable();
            $table->string('igv')->nullable();
            $table->string('icbper')->nullable();
            $table->string('terminos')->nullable();
            $table->dropColumn('impuesto');
            $table->dropColumn('series');
            $table->dropColumn('sunat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
