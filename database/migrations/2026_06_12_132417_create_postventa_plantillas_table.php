<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postventa_plantillas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('sector_id')->nullable()->constrained('sectores')->nullOnDelete();
            $table->text('cuerpo');
            $table->string('archivo_url')->nullable();
            $table->enum('archivo_tipo', ['pdf', 'video'])->nullable();
            $table->boolean('activo')->default(true);
            $table->index(['empresa_id', 'sector_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postventa_plantillas');
    }
};
