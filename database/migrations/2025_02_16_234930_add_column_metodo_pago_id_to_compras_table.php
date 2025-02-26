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
        Schema::table('compras', function (Blueprint $table) {
            $table->string('tipo_comprobante_id')->nullable()->index('compra_tipo_comprobante_id_foreign')->after('proveedor_id');
            $table->decimal('tipo_cambio', 10, 4)->nullable()->after('divisa');
            $table->foreign(['tipo_comprobante_id'])->references(['codigo'])->on('tipo_comprobantes')->onUpdate('cascade')->onDelete('cascade');

            $table->string('metodo_pago_id')->default('009')->after('tipo_comprobante_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compras', function (Blueprint $table) {

            $table->dropForeign('compra_tipo_comprobante_id_foreign');
            $table->dropColumn('tipo_comprobante_id');
            $table->dropColumn('tipo_cambio');
            $table->dropColumn('metodo_pago_id');
        });
    }
};
