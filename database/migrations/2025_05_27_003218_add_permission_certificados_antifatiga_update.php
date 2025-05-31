<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $permisos = [
            'ver-certificados-antifatiga',
            'crear-certificados-antifatiga',
            'editar-certificados-antifatiga',
            'descargar-certificados-antifatiga',
            'enviar-certificados-antifatiga',
            'eliminar-certificados-antifatiga',
        ];

        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
