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
        Schema::table('categorias', function (Blueprint $table) {
            if (collect(Schema::getIndexes('categorias'))->contains('name', 'categorias_nombre_unique')) {
                $table->dropUnique('categorias_nombre_unique');
            }
        });
    }

    public function down(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            if (!collect(Schema::getIndexes('categorias'))->contains('name', 'categorias_nombre_unique')) {
                $table->unique('nombre');
            }
        });
    }
};
