<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Primero cambiar el enum para incluir todos los valores
        DB::statement("ALTER TABLE compras MODIFY COLUMN pago_estado ENUM('UNPAID', 'PAID', 'PENDIENTE', 'PARCIAL') DEFAULT 'UNPAID'");

        // Luego actualizar valores existentes
        DB::statement("UPDATE compras SET pago_estado = 'PENDIENTE' WHERE pago_estado = 'UNPAID'");

        // Finalmente establecer el enum final sin UNPAID
        DB::statement("ALTER TABLE compras MODIFY COLUMN pago_estado ENUM('PENDIENTE', 'PARCIAL', 'PAID') DEFAULT 'PENDIENTE'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir valores a UNPAID
        DB::statement("UPDATE compras SET pago_estado = 'UNPAID' WHERE pago_estado = 'PENDIENTE'");

        // Volver al enum original
        DB::statement("ALTER TABLE compras MODIFY COLUMN pago_estado ENUM('UNPAID', 'PAID') DEFAULT 'UNPAID'");
    }
};
