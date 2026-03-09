<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tableName = config('laravel-subscriptions.tables.features');
        $oldIndexName = $tableName . '_slug_unique';
        $newIndexName = $tableName . '_plan_id_slug_unique';

        // Verificar si existe el índice antiguo
        $oldIndexExists = !empty(DB::select("SHOW INDEX FROM `{$tableName}` WHERE Key_name = ?", [$oldIndexName]));
        // Verificar si ya existe el nuevo índice compuesto
        $newIndexExists = !empty(DB::select("SHOW INDEX FROM `{$tableName}` WHERE Key_name = ?", [$newIndexName]));

        if ($oldIndexExists || !$newIndexExists) {
            Schema::table($tableName, function (Blueprint $table) use ($oldIndexExists, $newIndexExists, $oldIndexName): void {
                if ($oldIndexExists) {
                    $table->dropUnique($oldIndexName);
                }
                if (!$newIndexExists) {
                    $table->unique(['plan_id', 'slug']);
                }
            });
        }
    }
};
