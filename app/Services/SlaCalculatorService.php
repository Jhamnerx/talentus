<?php

namespace App\Services;

use App\Models\SlaPlanRule;
use Carbon\Carbon;

class SlaCalculatorService
{
    const BUSINESS_START = 9;
    const BUSINESS_END   = 18;
    const BUSINESS_DAYS  = [1, 2, 3, 4, 5]; // Lunes a Viernes

    /**
     * Calculates the effective SLA start time.
     * If scheduled_at is set and in the future relative to created_at, use it; otherwise use created_at.
     */
    public function slaStartsAt(?Carbon $scheduledAt, Carbon $createdAt): Carbon
    {
        if ($scheduledAt && $scheduledAt->isAfter($createdAt)) {
            return $scheduledAt->copy();
        }
        return $createdAt->copy();
    }

    /**
     * Calculates due_at (TR deadline) from the SLA plan rule.
     */
    public function calculateDueAt(string $planType, string $priority, Carbon $startTime): Carbon
    {
        $rule = SlaPlanRule::forPlan($planType, $priority);

        if (!$rule) {
            return $startTime->copy()->addHours($this->fallbackTrHours($priority));
        }

        $hours = (float) $rule->tr_hours;

        return $rule->tr_business_hours
            ? $this->addBusinessHours($startTime->copy(), $hours)
            : $startTime->copy()->addHours($hours);
    }

    /**
     * Calculates ts_at (TS remote restoration deadline) from the SLA plan rule.
     */
    public function calculateTsAt(string $planType, string $priority, Carbon $startTime): Carbon
    {
        $rule = SlaPlanRule::forPlan($planType, $priority);

        if (!$rule) {
            return $startTime->copy()->addHours($this->fallbackTsHours($priority));
        }

        $hours = (float) $rule->ts_remote_hours;

        return $rule->ts_business_hours
            ? $this->addBusinessHours($startTime->copy(), $hours)
            : $startTime->copy()->addHours($hours);
    }

    /**
     * Adds business hours (Mon-Fri 09:00-18:00) to a given time.
     */
    protected function addBusinessHours(Carbon $start, float $hours): Carbon
    {
        $minutesToAdd = (int) round($hours * 60);
        $current      = $this->moveToBusinessTime($start);

        while ($minutesToAdd > 0) {
            $endOfDay            = $current->copy()->setTime(self::BUSINESS_END, 0, 0);
            $minutesUntilEndOfDay = (int) $current->diffInMinutes($endOfDay);

            if ($minutesToAdd <= $minutesUntilEndOfDay) {
                $current->addMinutes($minutesToAdd);
                $minutesToAdd = 0;
            } else {
                $minutesToAdd -= $minutesUntilEndOfDay;
                $current       = $this->nextBusinessDayStart($current);
            }
        }

        return $current;
    }

    protected function moveToBusinessTime(Carbon $time): Carbon
    {
        $time = $time->copy();

        // Move past weekend to Monday
        while (!in_array($time->dayOfWeek, self::BUSINESS_DAYS)) {
            $time->addDay()->setTime(self::BUSINESS_START, 0, 0);
        }

        // Before business hours → move to start of day
        if ($time->hour < self::BUSINESS_START) {
            $time->setTime(self::BUSINESS_START, 0, 0);
        }

        // After business hours → move to next business day
        if ($time->hour >= self::BUSINESS_END) {
            $time = $this->nextBusinessDayStart($time);
        }

        return $time;
    }

    protected function nextBusinessDayStart(Carbon $from): Carbon
    {
        $next = $from->copy()->addDay()->setTime(self::BUSINESS_START, 0, 0);

        while (!in_array($next->dayOfWeek, self::BUSINESS_DAYS)) {
            $next->addDay();
        }

        return $next;
    }

    protected function fallbackTrHours(string $priority): int
    {
        return match ($priority) {
            'urgent' => 2,
            'high'   => 8,
            'medium' => 24,
            'low'    => 72,
            default  => 24,
        };
    }

    protected function fallbackTsHours(string $priority): int
    {
        return match ($priority) {
            'urgent' => 4,
            'high'   => 24,
            'medium' => 72,
            'low'    => 168,
            default  => 72,
        };
    }
}
