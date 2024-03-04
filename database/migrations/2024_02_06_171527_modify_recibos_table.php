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
        Schema::table('recibos', function (Blueprint $table) {
            $table->dropForeign('recibos_forma_pago_foreign');
        });

        Schema::table('recibos', function (Blueprint $table) {

            $table->string('forma_pago')->nullable()->change();
        });

        DB::table('recibos')->update(['forma_pago' => null]);

        Schema::table(
            'recibos',
            function (Blueprint $table) {

                $table->foreign('forma_pago')->references('codigo')->on('metodo_pago')->onDelete('cascade')->onUpdate('cascade');
            }
        );


        //recibos gerencia

        Schema::table('recibos_pagos', function (Blueprint $table) {
            $table->dropForeign('recibos_pagos_forma_pago_foreign');
            $table->enum('tipo_venta', ['CONTADO', 'CREDITO'])->default('CONTADO');
        });

        Schema::table('recibos_pagos', function (Blueprint $table) {

            $table->string('forma_pago')->nullable()->change();
        });

        DB::table('recibos_pagos')->update(['forma_pago' => null]);

        Schema::table(
            'recibos_pagos',
            function (Blueprint $table) {

                $table->foreign('forma_pago')->references('codigo')->on('metodo_pago')->onDelete('cascade')->onUpdate('cascade');
            }
        );

        Schema::table('detalle_recibos_pagos', function (Blueprint $table) {
            $table->unsignedBigInteger('producto_id')->unsigned()->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
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
