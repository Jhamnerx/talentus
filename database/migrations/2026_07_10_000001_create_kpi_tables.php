<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Definición de KPIs
        Schema::create('kpis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->string('area'); // comercial, operaciones, administracion, postventa, monitoreo, gerencia
            $table->string('nombre');
            $table->string('slug')->index();
            $table->text('descripcion')->nullable();
            $table->enum('tipo', ['auto', 'manual'])->default('auto');
            $table->decimal('meta', 10, 2)->default(0); // valor meta
            $table->decimal('meta_minima', 10, 2)->nullable(); // umbral amarillo
            $table->string('unidad')->default('%'); // %, und, s/, etc.
            $table->enum('frecuencia', ['diario', 'semanal', 'mensual'])->default('semanal');
            $table->string('responsable')->nullable(); // nombre del responsable
            $table->string('formula')->nullable(); // referencia a método en el servicio
            $table->boolean('activo')->default(true);
            $table->boolean('es_wig')->default(false);
            $table->integer('orden')->default(0);
            $table->timestamps();
        });

        // Resultados históricos de KPIs
        Schema::create('kpi_resultados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_id')->constrained('kpis')->cascadeOnDelete();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->date('periodo_inicio');
            $table->date('periodo_fin');
            $table->decimal('valor_actual', 10, 2)->default(0);
            $table->decimal('valor_meta', 10, 2)->default(0);
            $table->decimal('cumplimiento', 8, 2)->default(0); // porcentaje de cumplimiento
            $table->enum('semaforo', ['verde', 'amarillo', 'rojo'])->default('rojo');
            $table->text('notas')->nullable();
            $table->foreignId('registrado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('calculado_at')->nullable();
            $table->timestamps();

            $table->index(['kpi_id', 'periodo_inicio']);
            $table->index(['empresa_id', 'periodo_inicio']);
        });

        // Wildly Important Goals
        Schema::create('wigs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->decimal('meta', 10, 2)->default(100);
            $table->decimal('valor_actual', 10, 2)->default(0);
            $table->string('unidad')->default('%');
            $table->string('responsable')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('formula')->nullable(); // referencia a método calculador
            $table->enum('tipo', ['auto', 'manual'])->default('auto');
            $table->enum('estado', ['activo', 'completado', 'cancelado'])->default('activo');
            $table->integer('orden')->default(0);
            $table->timestamps();
        });

        // Alertas de KPIs
        Schema::create('kpi_alertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_id')->constrained('kpis')->cascadeOnDelete();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->enum('nivel', ['info', 'advertencia', 'critico'])->default('advertencia');
            $table->boolean('resuelto')->default(false);
            $table->timestamp('resuelto_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_alertas');
        Schema::dropIfExists('wigs');
        Schema::dropIfExists('kpi_resultados');
        Schema::dropIfExists('kpis');
    }
};
