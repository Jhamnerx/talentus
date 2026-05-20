<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_order_type_costs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_type_id');
            $table->unsignedBigInteger('tecnico_id');
            $table->decimal('costo', 10, 2)->default(0);
            $table->unsignedBigInteger('empresa_id');
            $table->timestamps();

            $table->unique(['work_order_type_id', 'tecnico_id'], 'unique_type_tecnico');
            $table->foreign('work_order_type_id')->references('id')->on('work_order_types')->onDelete('cascade');
            $table->foreign('tecnico_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_order_type_costs');
    }
};
