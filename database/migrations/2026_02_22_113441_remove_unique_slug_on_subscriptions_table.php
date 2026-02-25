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
        $tableName = config('laravel-subscriptions.tables.subscriptions');
        $indexName = $tableName . '_slug_unique';

        // Verificar si el índice existe antes de intentar eliminarlo
        $indexes = DB::select("SHOW INDEX FROM `{$tableName}` WHERE Key_name = ?", [$indexName]);

        if (!empty($indexes)) {
            Schema::table($tableName, function (Blueprint $table) use ($indexName): void {
                $table->dropUnique($indexName);
            });
        }
    }
};
