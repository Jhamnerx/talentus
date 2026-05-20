<?php

namespace App\Enums;

enum TicketEventType: string
{
    case CREATED = 'created';
    case STATUS_CHANGED = 'status_changed';
    case PRIORITY_CHANGED = 'priority_changed';
    case ASSIGNED_CHANGED = 'assigned_changed';
    case TEAM_CHANGED = 'team_changed';
    case MESSAGE_ADDED = 'message_added';
    case INTERNAL_NOTE = 'internal_note';
    case ATTACHMENT_ADDED = 'attachment_added';
    case REOPENED = 'reopened';
    case CLOSED = 'closed';
    case RESOLVED = 'resolved';
    case CATEGORY_CHANGED = 'category_changed';
    case ESCALATED = 'escalated';

    public function label(): string
    {
        return match ($this) {
            self::CREATED => 'Ticket creado',
            self::STATUS_CHANGED => 'Estado cambiado',
            self::PRIORITY_CHANGED => 'Prioridad cambiada',
            self::ASSIGNED_CHANGED => 'Asignación cambiada',
            self::TEAM_CHANGED => 'Equipo cambiado',
            self::MESSAGE_ADDED => 'Mensaje agregado',
            self::INTERNAL_NOTE => 'Nota interna agregada',
            self::ATTACHMENT_ADDED => 'Archivo adjuntado',
            self::REOPENED => 'Ticket reabierto',
            self::CLOSED => 'Ticket cerrado',
            self::RESOLVED => 'Ticket resuelto',
            self::CATEGORY_CHANGED => 'Categoría cambiada',
            self::ESCALATED => 'Ticket escalado',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::CREATED => 'plus-circle',
            self::STATUS_CHANGED => 'arrows-right-left',
            self::PRIORITY_CHANGED => 'flag',
            self::ASSIGNED_CHANGED => 'user',
            self::TEAM_CHANGED => 'users',
            self::MESSAGE_ADDED => 'chat-bubble-left',
            self::INTERNAL_NOTE => 'document-text',
            self::ATTACHMENT_ADDED => 'paper-clip',
            self::REOPENED => 'arrow-path',
            self::CLOSED => 'lock-closed',
            self::RESOLVED => 'check-circle',
            self::CATEGORY_CHANGED => 'tag',
            self::ESCALATED => 'arrow-up',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::CREATED => 'text-blue-600 dark:text-blue-400',
            self::STATUS_CHANGED => 'text-indigo-600 dark:text-indigo-400',
            self::PRIORITY_CHANGED => 'text-orange-600 dark:text-orange-400',
            self::ASSIGNED_CHANGED, self::TEAM_CHANGED => 'text-purple-600 dark:text-purple-400',
            self::MESSAGE_ADDED => 'text-blue-600 dark:text-blue-400',
            self::INTERNAL_NOTE => 'text-gray-600 dark:text-gray-400',
            self::ATTACHMENT_ADDED => 'text-teal-600 dark:text-teal-400',
            self::REOPENED => 'text-yellow-600 dark:text-yellow-400',
            self::CLOSED => 'text-gray-600 dark:text-gray-400',
            self::RESOLVED => 'text-green-600 dark:text-green-400',
            self::CATEGORY_CHANGED => 'text-pink-600 dark:text-pink-400',
            self::ESCALATED => 'text-red-600 dark:text-red-400',
        };
    }

    public function statusColor(): string
    {
        return match ($this) {
            self::CREATED => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            self::STATUS_CHANGED => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300',
            self::PRIORITY_CHANGED => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300',
            self::ASSIGNED_CHANGED, self::TEAM_CHANGED => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
            self::MESSAGE_ADDED => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            self::INTERNAL_NOTE => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
            self::ATTACHMENT_ADDED => 'bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-300',
            self::REOPENED => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            self::CLOSED => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
            self::RESOLVED => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            self::CATEGORY_CHANGED => 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-300',
            self::ESCALATED => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
        };
    }
}
