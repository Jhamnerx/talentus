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
        Schema::table('detalle_compras', function (Blueprint $table) {
            $table->unsignedBigInteger('compras_id')->after('importe');
            $table->unsignedBigInteger('producto_id')->nullable()->after('producto');
            $table->decimal('igv', 11, 4)->nullable()->after('importe');
            $table->decimal('importe_total', 11, 4)->nullable()->after('importe');
            $table->text('codigo')->nullable()->after('importe');
            $table->text('descripcion')->nullable()->after('producto');
            $table->foreign(['compras_id'])->references(['id'])->on('compras')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['producto_id'])->references(['id'])->on('productos')->onUpdate('cascade')->onDelete('cascade');
            $table->text('producto')->nullable()->change();
            $table->dropColumn('producto');
            $table->decimal('importe', 11, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
