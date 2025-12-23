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
        Schema::create('work_order_types', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->boolean('requiere_imei')->default(false);
            $table->boolean('requiere_sim')->default(false);
            $table->boolean('requiere_accesorios')->default(false);
            $table->boolean('requiere_checklist')->default(true);
            $table->decimal('costo_base', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('empresa_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_types');
    }
};
