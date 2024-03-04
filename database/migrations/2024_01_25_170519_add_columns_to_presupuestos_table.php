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
            $table->string('tipo_comprobante_id')->nullable()->after('id');
            $table->foreign('tipo_comprobante_id', 'fk_tipo_c_presupuesto')->references('codigo')->on('tipo_comprobantes');
            $table->string('serie_correlativo')->after('numero');
            $table->string('serie')->after('numero');
            $table->string('correlativo')->after('numero');
            $table->enum('forma_pago', ["CONTADO", "CREDITO"])->default('CONTADO')->after('divisa');
            $table->enum('pago_estado', ["UNPAID", "PAID"])->default('UNPAID')->after('divisa');
            $table->enum('resumen', ["si", "no"])->default('no')->after('divisa');
            $table->enum('anulado', ["si", "no"])->default('no')->after('divisa');
            $table->text('detalle_cuotas')->nullable()->after('divisa');
            $table->string('vence_cuotas')->nullable()->after('divisa');
            $table->string('numero_cuotas')->nullable()->after('divisa');
            $table->decimal('adelanto', 15, 4)->default(0.00)->after('divisa');
            $table->decimal('igv', 11, 4)->nullable()->after('divisa');
            $table->decimal('comision', 11, 4)->nullable()->after('igv');
            $table->decimal('icbper', 11, 4)->nullable()->after('divisa');
            $table->decimal('descuento_factor', 11, 5)->nullable()->after('divisa');
            $table->string('tipo_descuento')->nullable()->after('divisa');
            $table->decimal('descuento', 11, 2)->after('divisa');
            $table->decimal('igv_op', 11, 2)->default(0.00)->after('divisa');
            $table->decimal('op_gratuitas', 11, 2)->nullable()->after('divisa');
            $table->decimal('op_inafectas', 11, 2)->nullable()->after('divisa');
            $table->decimal('op_exoneradas', 11, 2)->nullable()->after('divisa');
            $table->decimal('op_gravadas', 11, 2)->nullable()->after('divisa');


            $table->decimal('descuento_soles', 11, 2)->nullable()->after('tipoCambio');
            $table->decimal('op_gravadas_soles', 11, 2)->nullable()->after('tipoCambio');
            $table->decimal('op_exoneradas_soles', 11, 2)->nullable()->after('tipoCambio');
            $table->decimal('op_inafectas_soles', 11, 2)->nullable()->after('tipoCambio');
            $table->decimal('igv_soles', 11, 2)->nullable()->after('tipoCambio');


            $table->text('comentario')->nullable()->after('divisa');
            $table->foreign('metodo_pago_id')->references('codigo')->on('metodo_pago')->onDelete('cascade')->onUpdate('cascade');
            $table->string('metodo_pago_id')->nullable()->after('divisa');
            $table->decimal('tipo_cambio', 11, 2)->nullable()->after('divisa');


            $table->string('numero')->nullable()->change();

            $table->text('terminos')->nullable()->after('nota');
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
