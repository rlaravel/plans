<?php

namespace RafaelMorenoJS\Plans\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use RafaelMorenoJS\Plans\Contracts\PlanSubscriptionInterface;
use RafaelMorenoJS\Plans\Getters\PlanSubscription as GetPlanSubscriptionAttributes;
use RafaelMorenoJS\Plans\Traits\BelongsToPlan;

/**
 * Class PlanSubscription
 * @package RafaelMorenoJS\Plans\Models
 * @property-read int $id
 * @property int $subscribable_id
 * @property string $subscribable_type
 * @property int $plan_id
 * @property string $name
 * @property bool $canceled_immediately
 * @property \Carbon\Carbon $trial_ends_at
 * @property \Carbon\Carbon $starts_at
 * @property \Carbon\Carbon $ends_at
 * @property \Carbon\Carbon $canceled_at
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class PlanSubscription extends Model implements PlanSubscriptionInterface
{
    use BelongsToPlan, GetPlanSubscriptionAttributes;

    const STATUS_ENDED = 'ended';
    const STATUS_ACTIVE = 'active';
    const STATUS_CANCELED = 'canceled';

    /**
     * @var array
     */
    protected $fillable = [
        'plan_id', 'name', 'trial_ends_at', 'starts_at', 'ends_at', 'canceled_at'
    ];

    /***
     * @var array
     */
    protected $dates = [
        'canceled_at', 'trial_ends_at', 'ends_at', 'starts_at'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'canceled_immediately' => 'boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscribable(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usage(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        // TODO: Implement usage() method.
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        // TODO: Implement isActive() method.
    }

    public function onTrial(): bool
    {
        // TODO: Implement onTrial() method.
    }

    /**
     * @return bool
     */
    public function isCanceled(): bool
    {
        return !is_null($this->canceled_at);
    }

    /**
     * @return bool
     */
    public function isEnded(): bool
    {
        $endsAt = Carbon::instance($this->ends_at);

        return Carbon::now()->gt($endsAt) || Carbon::now()->eq($endsAt);
    }

    /**
     * @return Model
     */
    public function renew(): \Illuminate\Database\Eloquent\Model
    {
        // TODO: Implement renew() method.
    }

    /**
     * @param bool $immediately
     * @return bool
     */
    public function cancel(bool $immediately = false): bool
    {
        // TODO: Implement cancel() method.
    }

    /**
     * @param Plan $plan
     * @return Model
     */
    public function changePlan(\RafaelMorenoJS\Plans\Models\Plan $plan): \Illuminate\Database\Eloquent\Model
    {
        // TODO: Implement changePlan() method.
    }
}