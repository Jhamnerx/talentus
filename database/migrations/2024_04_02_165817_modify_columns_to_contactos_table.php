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
        Schema::table('contactos', function (Blueprint $table) {
            $table->string('birthday')->change();
        });

        $contactos = DB::table('contactos')->get();

        foreach ($contactos as $contacto) {
            $birthday = date('Y-m-d', strtotime($contacto->birthday));
            DB::table('contactos')->where('id', $contacto->id)->update(['birthday' => $birthday]);
        }

        Schema::table('contactos', function (Blueprint $table) {
            $table->date('birthday')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contactos', function (Blueprint $table) {
            $table->string('birthday')->change();
        });
    }
};
