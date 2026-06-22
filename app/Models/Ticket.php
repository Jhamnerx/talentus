<?php

namespace App\Models;

use App\Enums\TicketStatus;
use App\Scopes\EmpresaScope;
use App\Enums\TicketPriority;
use App\Observers\TicketObserver;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(TicketObserver::class)]
class Ticket extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $recordEvents = ['deleted', 'created', 'updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'status'            => TicketStatus::class,
        'priority'          => TicketPriority::class,
        'last_activity_at'  => 'datetime',
        'first_response_at' => 'datetime',
        'resolved_at'       => 'datetime',
        'closed_at'         => 'datetime',
        'due_at'            => 'datetime',
        'scheduled_at'      => 'datetime',
        'ts_at'             => 'datetime',
        'escalation_level'  => 'integer',
    ];

    // Global Scope Empresa
    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);
    }

    // Relaciones
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TicketCategory::class, 'category_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'customer_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculo_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class, 'ticket_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(TicketAttachment::class, 'ticket_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(TicketEvent::class, 'ticket_id')->orderBy('created_at', 'desc');
    }

    // Scopes
    public function scopeStatus($query, $status)
    {
        if ($status instanceof TicketStatus) {
            return $query->where('status', $status->value);
        }
        return $query->where('status', $status);
    }

    public function scopePriority($query, $priority)
    {
        if ($priority instanceof TicketPriority) {
            return $query->where('priority', $priority->value);
        }
        return $query->where('priority', $priority);
    }

    public function scopeAssignedToUser($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeAssignedToTeam($query, $teamId)
    {
        return $query->where('team_id', $teamId);
    }

    public function scopeForCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    public function scopeOpen($query)
    {
        return $query->whereIn('status', [
            TicketStatus::NEW->value,
            TicketStatus::OPEN->value,
            TicketStatus::IN_PROGRESS->value,
            TicketStatus::WAITING_CUSTOMER->value,
            TicketStatus::WAITING_THIRD_PARTY->value,
        ]);
    }

    public function scopeClosed($query)
    {
        return $query->whereIn('status', [
            TicketStatus::RESOLVED->value,
            TicketStatus::CLOSED->value,
        ]);
    }

    public function scopeOverdue($query)
    {
        return $query->open()->whereNotNull('due_at')->where('due_at', '<', now());
    }

    // Helpers
    public function isOpen(): bool
    {
        return in_array($this->status, [
            TicketStatus::NEW,
            TicketStatus::OPEN,
            TicketStatus::IN_PROGRESS,
            TicketStatus::WAITING_CUSTOMER,
            TicketStatus::WAITING_THIRD_PARTY,
        ]);
    }

    public function isClosed(): bool
    {
        return in_array($this->status, [
            TicketStatus::RESOLVED,
            TicketStatus::CLOSED,
        ]);
    }

    public function canBeReopened(): bool
    {
        return $this->status === TicketStatus::CLOSED || $this->status === TicketStatus::RESOLVED;
    }

    public function isOverdue(): bool
    {
        return $this->isOpen() && $this->due_at !== null && $this->due_at->isPast();
    }

    /**
     * Returns the effective start of the SLA clock.
     * Scheduled tickets defer the clock until scheduled_at.
     */
    public function slaStartsAt(): \Carbon\Carbon
    {
        if ($this->scheduled_at && $this->scheduled_at->isAfter($this->created_at)) {
            return $this->scheduled_at;
        }
        return $this->created_at;
    }

    public function isScheduled(): bool
    {
        return $this->scheduled_at !== null && $this->scheduled_at->isAfter($this->created_at ?? now());
    }

    public function isAssignedTo(User $user): bool
    {
        return $this->assigned_to === $user->id;
    }

    public function belongsToTeam(Team $team): bool
    {
        return $this->team_id === $team->id;
    }

    public function relatedTickets(): HasMany
    {
        return $this->hasMany(TicketRelation::class, 'ticket_id');
    }
}
