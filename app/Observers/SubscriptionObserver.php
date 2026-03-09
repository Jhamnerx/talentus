<?php

namespace App\Observers;

use App\Models\Subscription;

class SubscriptionObserver
{
    public function creating(Subscription $subscription): void
    {
        if (empty($subscription->empresa_id) && session('empresa')) {
            $subscription->empresa_id = session('empresa');
        }
    }
}
