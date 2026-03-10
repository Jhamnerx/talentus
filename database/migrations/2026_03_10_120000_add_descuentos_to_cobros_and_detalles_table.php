<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cobros', function (Blueprint $table) {
            $table->decimal('descuento_global', 15, 2)->default(0)->after('nota');
        });

        Schema::table('detalles_cobros', function (Blueprint $table) {
            $table->decimal('descuento', 15, 2)->default(0)->after('monto_unidad');
        });
    }

    public function down(): void
    {
        Schema::table('cobros', function (Blueprint $table) {
            $table->dropColumn('descuento_global');
        });

        Schema::table('detalles_cobros', function (Blueprint $table) {
            $table->dropColumn('descuento');
        });
    }
};
