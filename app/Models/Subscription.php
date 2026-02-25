<?php

namespace App\Models;

use App\Observers\SubscriptionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Laravelcm\Subscriptions\Models\Subscription as BaseSubscription;

#[ObservedBy(SubscriptionObserver::class)]
class Subscription extends BaseSubscription
{
    protected $fillable = [
        'subscriber_id',
        'subscriber_type',
        'plan_id',
        'slug',
        'name',
        'description',
        'empresa_id',
        'trial_ends_at',
        'starts_at',
        'ends_at',
        'canceled_at',
    ];
}
