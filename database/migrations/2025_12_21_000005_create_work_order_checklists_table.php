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
        Schema::create('work_order_checklists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_id');
            $table->unsignedBigInteger('checklist_template_id');

            // Fase del checklist
            $table->enum('fase', ['before', 'after']); // ANTES o DESPUÉS

            // Resultado de la inspección
            $table->enum('resultado', ['ok', 'observado', 'no_aplica'])->nullable();
            $table->text('observaciones')->nullable();

            // Timestamps
            $table->dateTime('inspeccionado_at')->nullable();
            $table->unsignedBigInteger('inspeccionado_by')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('work_order_id')->references('id')->on('work_orders')->onDelete('cascade');
            $table->foreign('checklist_template_id')->references('id')->on('checklist_templates')->onDelete('restrict');
            $table->foreign('inspeccionado_by')->references('id')->on('users')->onDelete('set null');

            // Índices
            $table->index(['work_order_id', 'fase']);
            $table->unique(['work_order_id', 'checklist_template_id', 'fase']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_checklists');
    }
};
