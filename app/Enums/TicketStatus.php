<?php

namespace App\Enums;

enum TicketStatus: string
{
    case NEW = 'new';
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case WAITING_CUSTOMER = 'waiting_customer';
    case WAITING_THIRD_PARTY = 'waiting_third_party';
    case RESOLVED = 'resolved';
    case CLOSED = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::NEW => 'Nuevo',
            self::OPEN => 'Abierto',
            self::IN_PROGRESS => 'En Progreso',
            self::WAITING_CUSTOMER => 'Esperando Cliente',
            self::WAITING_THIRD_PARTY => 'Esperando Tercero',
            self::RESOLVED => 'Resuelto',
            self::CLOSED => 'Cerrado',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::NEW => 'text-blue-600 dark:text-blue-400',
            self::OPEN => 'text-indigo-600 dark:text-indigo-400',
            self::IN_PROGRESS => 'text-yellow-600 dark:text-yellow-400',
            self::WAITING_CUSTOMER => 'text-orange-600 dark:text-orange-400',
            self::WAITING_THIRD_PARTY => 'text-purple-600 dark:text-purple-400',
            self::RESOLVED => 'text-green-600 dark:text-green-400',
            self::CLOSED => 'text-gray-600 dark:text-gray-400',
        };
    }

    public function statusColor(): string
    {
        return match ($this) {
            self::NEW => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            self::OPEN => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300',
            self::IN_PROGRESS => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            self::WAITING_CUSTOMER => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300',
            self::WAITING_THIRD_PARTY => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
            self::RESOLVED => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            self::CLOSED => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        };
    }

    public function bgColor(): string
    {
        return match ($this) {
            self::NEW => 'bg-blue-500',
            self::OPEN => 'bg-indigo-500',
            self::IN_PROGRESS => 'bg-yellow-500',
            self::WAITING_CUSTOMER => 'bg-orange-500',
            self::WAITING_THIRD_PARTY => 'bg-purple-500',
            self::RESOLVED => 'bg-green-500',
            self::CLOSED => 'bg-gray-500',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->map(fn($case) => [
            'value' => $case->value,
            'label' => $case->label(),
        ])->toArray();
    }
}
