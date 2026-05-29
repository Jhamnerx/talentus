<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('modelos_dispositivos', function (Blueprint $table): void {
            $table->string('tecnologia', 50)->nullable()->after('modelo');
        });
    }

    public function down(): void
    {
        Schema::table('modelos_dispositivos', function (Blueprint $table): void {
            $table->dropColumn('tecnologia');
        });
    }
};
