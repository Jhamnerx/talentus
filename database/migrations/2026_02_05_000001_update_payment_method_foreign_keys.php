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
        Schema::disableForeignKeyConstraints();

        // Actualizar tabla VENTAS
        Schema::table('ventas', function (Blueprint $table) {
            // Eliminar foreign key antigua si existe
            $table->dropForeign(['metodo_pago_id']);
        });

        Schema::table('ventas', function (Blueprint $table) {
            // Crear nueva foreign key hacia payment_method_types
            $table->foreign('metodo_pago_id')
                ->references('id')
                ->on('payment_method_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        // Actualizar tabla RECIBOS
        Schema::table('recibos', function (Blueprint $table) {
            // Eliminar foreign key antigua si existe
            $table->dropForeign(['forma_pago']);
        });

        Schema::table('recibos', function (Blueprint $table) {
            // Crear nueva foreign key hacia payment_method_types
            $table->foreign('forma_pago')
                ->references('id')
                ->on('payment_method_types')
                ->onDelete('set null');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        // Revertir VENTAS
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropForeign(['metodo_pago_id']);
        });

        Schema::table('ventas', function (Blueprint $table) {
            $table->foreign('metodo_pago_id')
                ->references('codigo')
                ->on('metodo_pago')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        // Revertir RECIBOS
        Schema::table('recibos', function (Blueprint $table) {
            $table->dropForeign(['forma_pago']);
        });

        Schema::table('recibos', function (Blueprint $table) {
            $table->foreign('forma_pago')
                ->references('id')
                ->on('payment_methods')
                ->onDelete('set null');
        });

        Schema::enableForeignKeyConstraints();
    }
};
