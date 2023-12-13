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

        Schema::create('tipo_afectacion', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->index()->unique();
            $table->text('descripcion')->nullable();
            $table->string('codigo_afectacion')->nullable();
            $table->text('nombre_afectacion')->nullable();
            $table->string('tipo_afectacion')->nullable();
            $table->string('letra')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_afectacion');
    }
};
