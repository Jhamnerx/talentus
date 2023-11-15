<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('productos')->update(['descripcion' => DB::raw('nombre')]);

        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('nombre');
            $table->decimal('valor_unitario', 10, 4);
            //$table->dropColumn('precio');

        });
        DB::table('productos')->update(['valor_unitario' => DB::raw('precio')]);

        Schema::table('productos', function (Blueprint $table) {
            $table->boolean('afecto_icbper')->default(false)->after('stock');
            $table->dropColumn('precio')->after('stock');
            //$table->boolean('afecto_icbper')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            //
        });
    }
};
