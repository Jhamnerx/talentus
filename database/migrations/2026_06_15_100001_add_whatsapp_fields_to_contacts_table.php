<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->unsignedBigInteger('empresa_id')->default(1)->after('id')->index();
            $table->unsignedBigInteger('cliente_id')->nullable()->after('empresa_id');
            $table->string('wa_jid')->nullable()->after('number');
            $table->string('push_name')->nullable()->after('wa_jid');
            $table->string('profile_pic_url')->nullable()->after('push_name');
            $table->json('metadata')->nullable()->after('profile_pic_url');

            $table->unique(['empresa_id', 'number']);
            $table->index('cliente_id');
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropUnique(['empresa_id', 'number']);
            $table->dropIndex(['cliente_id']);
            $table->dropIndex(['empresa_id']);
            $table->dropColumn([
                'empresa_id', 'cliente_id', 'wa_jid',
                'push_name', 'profile_pic_url', 'metadata',
            ]);
        });
    }
};
