<?php

namespace App\Models\WhatsFleep;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sender',
        'name',
        'phonebook_id',
        'type',
        'status',
        'message',
        'schedule',
        'delay',
    ];

    protected $casts = [
        'schedule' => 'datetime',
        'delay'    => 'integer',
    ];

    public function blasts()
    {
        return $this->hasMany(Blast::class);
    }

    public function phonebook()
    {
        return $this->belongsTo(WaTag::class, 'phonebook_id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'sender', 'body');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, $request)
    {
        return $query
            ->when($request->device, function ($q) use ($request) {
                return $q->whereHas('device', function ($q) use ($request) {
                    return $q->where('body', '=', $request->device);
                });
            })
            ->when($request->status, function ($q) use ($request) {
                if ($request->status == 'all') {
                    return $q;
                } else {
                    return $q->where('status', '=', $request->status);
                }
            });
    }

    public function getScheduleAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d M y H:i') : null;
    }
}
