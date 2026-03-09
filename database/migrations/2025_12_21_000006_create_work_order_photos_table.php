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
        Schema::create('work_order_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_id');
            $table->unsignedBigInteger('work_order_checklist_id')->nullable(); // Si es de un ítem específico

            // Archivo
            $table->string('filename');
            $table->string('path');
            $table->string('disk')->default('private');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable(); // bytes

            // Metadata
            $table->enum('tipo', ['checklist', 'general', 'evidencia'])->default('evidencia');
            $table->enum('fase', ['before', 'after', 'proceso'])->nullable();
            $table->text('descripcion')->nullable();

            // Geolocalización
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Usuario
            $table->unsignedBigInteger('uploaded_by');

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('work_order_id')->references('id')->on('work_orders')->onDelete('cascade');
            $table->foreign('work_order_checklist_id')->references('id')->on('work_order_checklists')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('restrict');

            // Índices
            $table->index('work_order_id');
            $table->index('tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_photos');
    }
};
