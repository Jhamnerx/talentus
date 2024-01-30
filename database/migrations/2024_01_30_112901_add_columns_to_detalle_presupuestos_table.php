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
        Schema::table('detalle_presupuestos', function (Blueprint $table) {
            $table->decimal('sub_total', 11, 4)->nullable()->after('descuento_type');
            $table->decimal('descuento_factor', 11, 5)->nullable()->after('descuento_val');
            $table->string('porcentaje_igv')->nullable()->after('descuento_type');
            $table->decimal('total_icbper', 11, 4)->nullable()->after('descuento_type');
            $table->decimal('icbper', 11, 4)->nullable()->after('descuento_type');
            $table->boolean('afecto_icbper')->default(false)->after('descuento_type');
            $table->decimal('precio_unitario', 11, 4)->after('descuento_type');
            $table->decimal('valor_unitario', 11, 4)->after('descuento_type');
            $table->string('tipo_precio')->nullable()->after('descuento_type');
            $table->string('codigo_afectacion')->nullable()->after('descuento_type');
            $table->text('unit_name')->nullable()->after('descuento_type');
            $table->text('unit')->nullable()->after('descuento_type');
            $table->text('codigo')->nullable()->after('descuento_type');

            $table->text('producto')->nullable()->change();
            $table->decimal('precio', 15, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalle_presupuestos', function (Blueprint $table) {
            //
        });
    }
};
