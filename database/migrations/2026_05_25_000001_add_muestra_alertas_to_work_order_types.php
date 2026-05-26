<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_order_types', function (Blueprint $table) {
            $table->boolean('muestra_alertas')
                ->default(true)
                ->after('muestra_accesorios_instalar')
                ->comment('Muestra el apartado de alertas GPS a configurar en la orden');
        });
    }

    public function down(): void
    {
        Schema::table('work_order_types', function (Blueprint $table) {
            $table->dropColumn('muestra_alertas');
        });
    }
};
