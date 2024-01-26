<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->string('tipo_comprobante_id')->default('00')->nullable()->after('id');
            $table->foreign('tipo_comprobante_id', 'fk_tipo_c_presupuesto')->references('codigo')->on('tipo_comprobantes');
            $table->string('serie_correlativo')->after('numero');
            $table->string('serie')->after('numero');
            $table->string('correlativo')->after('numero');
        });

        DB::table('presupuestos')->update(['serie_correlativo' => DB::raw('numero')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            //
        });
    }
};
