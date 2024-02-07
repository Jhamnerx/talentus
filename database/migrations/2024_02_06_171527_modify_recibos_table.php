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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
