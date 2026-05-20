<?php

namespace App\Models\WhatsFleep;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Phonebook / tag de contactos de WhatsApp.
 * Se usa tabla "tags" para mantener compatibilidad con whats-fleep.
 */
class WaTag extends Model
{
    use HasFactory;

    protected $table = 'tags';

    protected $fillable = [
        'user_id',
        'name',
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'tag_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'phonebook_id');
    }
}
