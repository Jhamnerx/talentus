<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->string('sector')->nullable()->after('observaciones_inicial');
            $table->string('plan')->nullable()->after('sector');
            $table->string('contacto')->nullable()->after('plan')
                ->comment('Persona de contacto del cliente para la orden');
        });
    }

    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn(['sector', 'plan', 'contacto']);
        });
    }
};
