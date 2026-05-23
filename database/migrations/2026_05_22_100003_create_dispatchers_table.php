<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dispatchers', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_doc', 2)->default('6'); // 6=RUC, 1=DNI
            $table->string('numero_doc', 20);
            $table->string('razon_social');
            $table->string('address')->nullable();
            $table->string('numero_mtc')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dispatchers');
    }
};
