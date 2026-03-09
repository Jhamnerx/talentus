<?php

namespace App\Models;

use App\Enums\TicketEventType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketEvent extends Model
{
    use HasFactory;

    const UPDATED_AT = null; // Solo usa created_at

    protected $guarded = ['id', 'created_at'];

    protected $casts = [
        'type' => TicketEventType::class,
        'payload' => 'array',
        'created_at' => 'datetime',
    ];

    // Relaciones
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    // Helpers
    public function getPayloadValue(string $key, $default = null)
    {
        return data_get($this->payload, $key, $default);
    }
}
