<?php

namespace App\Enums;

enum TicketPriority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case URGENT = 'urgent';

    public function label(): string
    {
        return match ($this) {
            self::LOW => 'Baja',
            self::MEDIUM => 'Media',
            self::HIGH => 'Alta',
            self::URGENT => 'Urgente',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::LOW => 'text-gray-600 dark:text-gray-400',
            self::MEDIUM => 'text-blue-600 dark:text-blue-400',
            self::HIGH => 'text-orange-600 dark:text-orange-400',
            self::URGENT => 'text-red-600 dark:text-red-400',
        };
    }

    public function statusColor(): string
    {
        return match ($this) {
            self::LOW => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
            self::MEDIUM => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            self::HIGH => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300',
            self::URGENT => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
        };
    }

    public function bgColor(): string
    {
        return match ($this) {
            self::LOW => 'bg-gray-500',
            self::MEDIUM => 'bg-blue-500',
            self::HIGH => 'bg-orange-500',
            self::URGENT => 'bg-red-500',
        };
    }

    public function sortOrder(): int
    {
        return match ($this) {
            self::LOW => 1,
            self::MEDIUM => 2,
            self::HIGH => 3,
            self::URGENT => 4,
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
