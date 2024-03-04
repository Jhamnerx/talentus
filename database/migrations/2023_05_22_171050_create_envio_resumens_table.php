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

        Schema::create('envio_resumen', function (Blueprint $table) {
            $table->id();
            $table->string('correlativo')->nullable();
            $table->string('resumen')->nullable();
            $table->string('baja')->nullable();
            $table->text('nombre_xml')->nullable();
            $table->string('fe_estado')->nullable();
            $table->text('fe_codigo_error')->nullable();
            $table->text('fe_mensaje_sunat')->nullable();
            $table->text('ticket')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');

            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envio_resumens');
    }
};
