<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->string('stock')->nullable();
            $table->decimal('precio', 10, 2);
            $table->string('divisa')->nullable();
            $table->enum('tipo', ['producto', 'servicio'])->default('producto');
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->unsignedBigInteger('empresa_id');
            $table->enum('is_favorite', ['yes', 'no'])->default('no');
            $table->boolean('is_active')->default(true);
            $table->string('unit_code')->nullable();

            $table->foreign('unit_code')->references('codigo')->on('units')->onDelete('cascade');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
