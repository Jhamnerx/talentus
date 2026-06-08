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
        Schema::table('work_order_accessories', function (Blueprint $table) {
            $table->dropColumn(['serial', 'precio_unitario', 'subtotal']);
        });
    }

    public function down(): void
    {
        Schema::table('work_order_accessories', function (Blueprint $table) {
            $table->string('serial')->nullable()->after('cantidad');
            $table->decimal('precio_unitario', 10, 2)->default(0)->after('serial');
            $table->decimal('subtotal', 10, 2)->default(0)->after('precio_unitario');
        });
    }
};
