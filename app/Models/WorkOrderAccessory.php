<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\WorkOrderAccessoryObserver;

#[ObservedBy(WorkOrderAccessoryObserver::class)]
class WorkOrderAccessory extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'cantidad' => 'integer',
    ];

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Productos::class, 'producto_id')->withTrashed();
    }
}
