<?php

namespace MorenoRafael\Plans\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MorenoRafael\Plans\Contracts\PlanInterface;
use MorenoRafael\Plans\Exceptions\InvalidPlanFeatureException;
use MorenoRafael\Plans\Getters\Plan as GetPlanAttributes;

/**
 * Class Plan
 * @package MorenoRafael\Plans\Models
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
 * @property-read \MorenoRafael\Plans\Models\PlanFeature[]|\Illuminate\Support\Collection $features
 * @property-read \MorenoRafael\Plans\Models\PlanSubscription[]|\Illuminate\Support\Collection $subscriptions
 * @mixin \Eloquent
 */
class Plan extends Model implements PlanInterface
{
    use GetPlanAttributes;

    /**
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price', 'interval', 'interval_count', 'trial_period_days', 'sort_order',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (! $model->interval) {
                $model->interval = 'month';
            }

            if (! $model->interval_count) {
                $model->interval_count = 1;
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function features(): HasMany
    {
        return $this->hasMany(PlanFeature::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions(): HasMany
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

    /**
     * @param $code
     * @return mixed
     * @throws InvalidPlanFeatureException
     */
    public function getFeatureByCode($code)
    {
        $feature = $this->features()->getEager()->first(function($item) use ($code) {
            return $item->code === $code;
        });

        if (is_null($feature)) {
            throw new InvalidPlanFeatureException($code);
        }
        return $feature;
    }
}
