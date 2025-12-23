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
        Schema::create('checklist_templates', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('categoria', ['vehiculo', 'tablero', 'luces', 'accesorios', 'motor', 'neumaticos', 'documentos', 'otros'])->default('otros');
            $table->text('descripcion')->nullable();
            $table->boolean('requiere_foto')->default(false);
            $table->integer('orden')->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('empresa_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');

            // Índices
            $table->index(['empresa_id', 'categoria']);
            $table->index('orden');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_templates');
    }
};
