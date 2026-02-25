<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tableName = config('laravel-subscriptions.tables.subscriptions');

        // Verificar si la columna existe antes de eliminarla
        if (Schema::hasColumn($tableName, 'cancels_at')) {
            Schema::table($tableName, static function (Blueprint $table): void {
                $table->dropColumn('cancels_at');
            });
        }
    }
};
