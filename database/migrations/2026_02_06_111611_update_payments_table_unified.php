<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración consolida TODOS los campos necesarios para que payments
     * funcione como tabla unificada (reemplazando global_payments).
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // ========== CAMPOS DE DESTINO (antes en destination_to_payments) ==========
            if (!Schema::hasColumn('payments', 'destination_type')) {
                $table->string('destination_type')->nullable()->after('payment_method_id')
                    ->comment('Tipo de destino polimórfico: Cash, BankAccount');
            }
            if (!Schema::hasColumn('payments', 'destination_id')) {
                $table->unsignedBigInteger('destination_id')->nullable()->after('destination_type')
                    ->comment('ID del destino polimórfico');
                $table->index(['destination_type', 'destination_id'], 'payments_destination_index');
            }

            // ========== BANCO (antes en add_bank_account_id) ==========
            if (!Schema::hasColumn('payments', 'bank_account_id')) {
                $table->foreignId('bank_account_id')->nullable()->after('payment_method_id')
                    ->constrained('bank_accounts')->onDelete('set null')
                    ->comment('Cuenta bancaria si el método de pago es bancario');
            }

            // ========== DESTINO SELECTOR (antes en add_payment_destination_id) ==========
            if (!Schema::hasColumn('payments', 'payment_destination_id')) {
                $table->string('payment_destination_id')->nullable()->after('bank_account_id')
                    ->comment('ID del destino seleccionado: "cash" o ID de cuenta bancaria');
            }

            // ========== TIPO DE CAMBIO ==========
            if (!Schema::hasColumn('payments', 'tipo_cambio')) {
                $table->decimal('tipo_cambio', 8, 4)->default(1)->after('divisa')
                    ->comment('Tipo de cambio del documento');
            }

            // ========== CAMPOS DE GLOBAL_PAYMENT (unificación) ==========
            if (!Schema::hasColumn('payments', 'type_movement')) {
                $table->enum('type_movement', ['INGRESO', 'EGRESO'])->nullable()->after('monto')
                    ->comment('Tipo de movimiento: INGRESO (ventas, recibos) o EGRESO (compras, gastos)');
            }
            if (!Schema::hasColumn('payments', 'description')) {
                $table->text('description')->nullable()->after('type_movement')
                    ->comment('Descripción automática del movimiento');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Eliminar índices antes de columnas
            if (Schema::hasColumn('payments', 'destination_type')) {
                $table->dropIndex('payments_destination_index');
            }

            // Eliminar foreign keys
            if (Schema::hasColumn('payments', 'bank_account_id')) {
                $table->dropForeign(['bank_account_id']);
            }

            // Eliminar columnas en orden inverso
            $columnsToRemove = [];
            if (Schema::hasColumn('payments', 'description')) $columnsToRemove[] = 'description';
            if (Schema::hasColumn('payments', 'type_movement')) $columnsToRemove[] = 'type_movement';
            if (Schema::hasColumn('payments', 'tipo_cambio')) $columnsToRemove[] = 'tipo_cambio';
            if (Schema::hasColumn('payments', 'payment_destination_id')) $columnsToRemove[] = 'payment_destination_id';
            if (Schema::hasColumn('payments', 'bank_account_id')) $columnsToRemove[] = 'bank_account_id';
            if (Schema::hasColumn('payments', 'destination_id')) $columnsToRemove[] = 'destination_id';
            if (Schema::hasColumn('payments', 'destination_type')) $columnsToRemove[] = 'destination_type';

            if (!empty($columnsToRemove)) {
                $table->dropColumn($columnsToRemove);
            }
        });
    }
};
