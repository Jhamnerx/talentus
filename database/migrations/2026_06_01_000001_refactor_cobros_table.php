<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Reconstruye el sistema de cobros:
 *  - Elimina detalles_cobros (tabla intermedia legacy)
 *  - Elimina notificaciones_cobro (reemplazada por periodos_cobros)
 *  - Recrea cobros como tabla POR VEHÍCULO (1 cobro = 1 vehículo)
 *  - Crea periodos_cobros para el historial de facturación
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('detalles_cobros');
        Schema::dropIfExists('notificaciones_cobro');
        Schema::dropIfExists('periodos_cobros');
        Schema::dropIfExists('cobros');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ── cobros: un registro por vehículo ─────────────────────────────────
        Schema::create('cobros', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas')->cascadeOnDelete();

            $table->unsignedBigInteger('clientes_id');
            $table->foreign('clientes_id')->references('id')->on('clientes')->cascadeOnDelete();

            $table->unsignedBigInteger('vehiculos_id')->nullable();
            $table->foreign('vehiculos_id')->references('id')->on('vehiculos')->nullOnDelete();

            $table->unsignedBigInteger('plan_id')->nullable();
            $table->foreign('plan_id')->references('id')->on('plans')->nullOnDelete();

            $table->string('periodo', 50)->default('MENSUAL');
            $table->decimal('monto', 15, 4)->nullable();
            $table->decimal('descuento', 15, 2)->default(0);

            $table->char('divisa', 3)->default('PEN');
            $table->string('tipo_pago')->nullable();
            $table->string('nota')->nullable();
            $table->string('observacion')->nullable();
            $table->text('comentario')->nullable();

            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_vencimiento')->nullable();

            $table->enum('estado', ['ACTIVO', 'SUSPENDIDO', 'CANCELADO', 'CORTESIA'])
                ->default('ACTIVO');

            $table->softDeletes();
            $table->timestamps();

            $table->index(['empresa_id', 'estado']);
            $table->index(['empresa_id', 'clientes_id']);
            $table->index(['empresa_id', 'fecha_vencimiento', 'estado']);
        });

        // ── periodos_cobros: historial de facturación por cobro ──────────────
        Schema::create('periodos_cobros', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas')->cascadeOnDelete();

            $table->unsignedBigInteger('cobros_id');
            $table->foreign('cobros_id')->references('id')->on('cobros')->cascadeOnDelete();

            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes')->cascadeOnDelete();

            $table->unsignedBigInteger('vehiculo_id')->nullable();
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->nullOnDelete();

            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            $table->string('periodo', 50)->default('MENSUAL');
            $table->decimal('monto', 15, 4);
            $table->char('divisa', 3)->default('PEN');

            $table->enum('tipo', ['INICIAL', 'RENOVACION'])->default('INICIAL');
            $table->enum('estado', ['PENDIENTE', 'FACTURADO', 'PAGADO', 'CANCELADO'])->default('PENDIENTE');

            $table->unsignedBigInteger('venta_id')->nullable();
            $table->foreign('venta_id')->references('id')->on('ventas')->nullOnDelete();

            $table->unsignedBigInteger('recibo_id')->nullable();
            $table->foreign('recibo_id')->references('id')->on('recibos')->nullOnDelete();

            $table->timestamp('fecha_pago')->nullable();
            $table->text('observaciones')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index(['empresa_id', 'estado']);
            $table->index(['empresa_id', 'fecha_fin', 'estado']);
            $table->index('cobros_id');
        });
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('periodos_cobros');
        Schema::dropIfExists('cobros');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Recrear cobros con estructura original mínima
        Schema::create('cobros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas')->cascadeOnDelete();
            $table->unsignedBigInteger('clientes_id');
            $table->foreign('clientes_id')->references('id')->on('clientes')->cascadeOnDelete();
            $table->unsignedBigInteger('vehiculos_id');
            $table->foreign('vehiculos_id')->references('id')->on('vehiculos')->cascadeOnDelete();
            $table->unsignedBigInteger('contratos_id')->nullable();
            $table->text('comentario')->nullable();
            $table->string('periodo');
            $table->string('divisa');
            $table->decimal('monto_unidad', 10, 2);
            $table->integer('cantidad_unidades')->nullable();
            $table->string('tipo_pago');
            $table->string('nota')->nullable();
            $table->string('observacion')->nullable();
            $table->date('fecha_vencimiento');
            $table->enum('estado', ['0', '1', '2'])->default('0');
            $table->boolean('suspendido')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }
};


/**
 * Refactoriza la tabla cobros para que sea UN REGISTRO POR VEHÍCULO:
 * - Elimina columnas legacy: contratos_id, suspendido, descuento_global,
 *   producto_id, monto_unidad, cantidad_unidades
 * - Mantiene vehiculos_id como FK al vehículo del cobro
 * - Corrige el enum 'estado' a CobroEstado (ACTIVO, SUSPENDIDO, CANCELADO, CORTESIA)
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('cobros')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Schema::table('cobros', function (Blueprint $table) {
            $fks = DB::select("
                SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'cobros'
                  AND REFERENCED_TABLE_NAME IS NOT NULL
                  AND COLUMN_NAME IN ('contratos_id','producto_id')
            ");
            foreach ($fks as $fk) {
                $table->dropForeign($fk->CONSTRAINT_NAME);
            }

            $columns = Schema::getColumnListing('cobros');
            $toDrop  = array_intersect(
                ['contratos_id', 'suspendido', 'descuento_global', 'produto_id', 'producto_id', 'monto_unidad', 'cantidad_unidades'],
                $columns
            );
            if ($toDrop) {
                $table->dropColumn(array_values($toDrop));
            }

            // Columnas requeridas para arquitectura per-vehicle
            if (!in_array('vehiculos_id', $columns)) {
                $table->unsignedBigInteger('vehiculos_id')->nullable()->after('clientes_id');
                $table->foreign('vehiculos_id')->references('id')->on('vehiculos')->nullOnDelete();
            }
            if (!in_array('fecha_inicio', $columns)) {
                $table->date('fecha_inicio')->nullable()->after('descuento');
            }
            if (!in_array('fecha_vencimiento', $columns)) {
                $table->date('fecha_vencimiento')->nullable()->after('fecha_inicio');
            }
            if (!in_array('observacion', $columns)) {
                $table->string('observacion')->nullable()->after('nota');
            }
        });

        DB::statement("ALTER TABLE cobros MODIFY COLUMN estado ENUM('ACTIVO','SUSPENDIDO','CANCELADO','CORTESIA') NOT NULL DEFAULT 'ACTIVO'");
    }

    public function down(): void
    {
        Schema::table('cobros', function (Blueprint $table) {
            $table->unsignedBigInteger('contratos_id')->nullable();
            $table->boolean('suspendido')->default(false);
            $table->decimal('descuento_global', 15, 2)->default(0);
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->decimal('monto_unidad', 15, 2)->nullable();
            $table->unsignedInteger('cantidad_unidades')->nullable();
        });
        DB::statement("ALTER TABLE cobros MODIFY COLUMN estado ENUM('0','1','2') NOT NULL DEFAULT '0'");
    }
};
