<?php

namespace RafaelMorenoJS\Plans\Models;

use Illuminate\Database\Eloquent\Model;
use RafaelMorenoJS\Plans\Contracts\PlanInterface;

/**
 * Class Plan
 * @package RafaelMorenoJS\Plans\Models
 * @property-read int $id
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property string $interval
 * @property int $interval_count
 * @property int|null $trial_period_days
 * @property int|null $sort_order
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @property-read \RafaelMorenoJS\Plans\Models\PlanFeature[]|\Illuminate\Support\Collection $features
 * @property-read \RafaelMorenoJS\Plans\Models\PlanSubscription[]|\Illuminate\Support\Collection $subscriptions
 * @mixin \Eloquent
 */
class Plan extends Model implements PlanInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price', 'interval', 'interval_count', 'trial_period_days', 'sort_order',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function features(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PlanFeature::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PlanSubscription::class);
    }

    /**
     * @return bool
     */
    public function isFree(): bool
    {
        return $this->price <= 0.00;
    }

    /**
     * @return bool
     */
    public function hasTrial(): bool
    {
        return (is_numeric($this->trial_period_days) && $this->trial_period_days > 0);
    }
}