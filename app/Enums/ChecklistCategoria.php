<?php

namespace App\Enums;

enum ChecklistCategoria: string
{
    case VEHICULO = "vehiculo";
    case TABLERO = "tablero";
    case LUCES = "luces";
    case ACCESORIOS = "accesorios";
    case MOTOR = "motor";
    case NEUMATICOS = "neumaticos";
    case DOCUMENTOS = "documentos";
    case OTROS = "otros";

    public function label(): string
    {
        return match ($this) {
            ChecklistCategoria::VEHICULO => 'Vehículo',
            ChecklistCategoria::TABLERO => 'Tablero',
            ChecklistCategoria::LUCES => 'Luces',
            ChecklistCategoria::ACCESORIOS => 'Accesorios',
            ChecklistCategoria::MOTOR => 'Motor',
            ChecklistCategoria::NEUMATICOS => 'Neumáticos',
            ChecklistCategoria::DOCUMENTOS => 'Documentos',
            ChecklistCategoria::OTROS => 'Otros',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            ChecklistCategoria::VEHICULO => 'truck',
            ChecklistCategoria::TABLERO => 'view-grid',
            ChecklistCategoria::LUCES => 'light-bulb',
            ChecklistCategoria::ACCESORIOS => 'puzzle',
            ChecklistCategoria::MOTOR => 'cog',
            ChecklistCategoria::NEUMATICOS => 'refresh',
            ChecklistCategoria::DOCUMENTOS => 'document-text',
            ChecklistCategoria::OTROS => 'dots-horizontal',
        };
    }

    public function color(): string
    {
        return match ($this) {
            ChecklistCategoria::VEHICULO => 'text-blue-500',
            ChecklistCategoria::TABLERO => 'text-purple-500',
            ChecklistCategoria::LUCES => 'text-yellow-500',
            ChecklistCategoria::ACCESORIOS => 'text-pink-500',
            ChecklistCategoria::MOTOR => 'text-red-500',
            ChecklistCategoria::NEUMATICOS => 'text-gray-600',
            ChecklistCategoria::DOCUMENTOS => 'text-indigo-500',
            ChecklistCategoria::OTROS => 'text-gray-400',
        };
    }
}
