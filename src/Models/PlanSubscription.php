<?php

namespace RafaelMorenoJS\Plans\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use RafaelMorenoJS\Plans\Contracts\PlanInterface;
use RafaelMorenoJS\Plans\Contracts\PlanSubscriptionInterface;
use RafaelMorenoJS\Plans\Events\SubscriptionCanceled;
use RafaelMorenoJS\Plans\Events\SubscriptionCreated;
use RafaelMorenoJS\Plans\Events\SubscriptionPlanChanged;
use RafaelMorenoJS\Plans\Events\SubscriptionRenewed;
use RafaelMorenoJS\Plans\Getters\PlanSubscription as GetPlanSubscriptionAttributes;
use RafaelMorenoJS\Plans\Period;
use RafaelMorenoJS\Plans\SubscriptionAbility;
use RafaelMorenoJS\Plans\SubscriptionUsageManager;
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

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            Event::fire(new SubscriptionCreated($model));
        });

        static::saving(function ($model) {
            // Set period if it wasn't set
            if (! $model->ends_at) {
                $model->setNewPeriod();
            }
        });

        static::saved(function ($model) {
            // check if there is a plan and it is changed
            if ($model->getOriginal('plan_id') && $model->getOriginal('plan_id') !== $model->plan_id) {
                event(new SubscriptionPlanChanged($model));
            }
        });
    }

    /**
     * @param string $interval
     * @param string $interval_count
     * @param string $start
     * @return $this
     * @throws \RafaelMorenoJS\Plans\Exceptions\InvalidIntervalException
     */
    protected function setNewPeriod($interval = '', $interval_count = '', $start = '')
    {
        if (empty($interval)) {
            $interval = $this->plan->interval;
        }
        if (empty($interval_count)) {
            $interval_count = $this->plan->interval_count;
        }

        $period = new Period($interval, $interval_count, $start);
        $this->starts_at = $period->getStartDate();
        $this->ends_at = $period->getEndDate();

        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscribable(): BelongsTo
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usage(): HasMany
    {
        return $this->hasMany(PlanSubscriptionUsage::class, 'subscription_id');
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        if ((!$this->isEnded() or $this->onTrial()) && !$this->isCanceledImmediately()) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function onTrial(): bool
    {
        if (! is_null($trialEndsAt = $this->trial_ends_at)) {
            return Carbon::now()->lt(Carbon::instance($trialEndsAt));
        }

        return false;
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
    public function isCanceledImmediately()
    {
        return  (!is_null($this->canceled_at) && $this->canceled_immediately === true);
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
    public function renew(): Model
    {
        if ($this->isEnded() and $this->isCanceled()) {
            throw new \LogicException('Unable to renew canceled ended subscription.');
        }

        $subscription = $this;
        DB::transaction(function () use ($subscription) {
            // Clear usage data
            $usageManager = new SubscriptionUsageManager($subscription);
            $usageManager->clear();
            // Renew period
            $subscription->setNewPeriod();
            $subscription->canceled_at = null;
            $subscription->save();
        });

        event(new SubscriptionRenewed($this));

        return $this;
    }

    /**
     * @return mixed|SubscriptionAbility
     */
    public function ability()
    {
        if (is_null($this->ability)) {
            return new SubscriptionAbility($this);
        }
        return $this->ability;
    }

    /**
     * @param bool $immediately
     * @return bool
     */
    public function cancel(bool $immediately = false): bool
    {
        $this->canceled_at = Carbon::now();

        if ($immediately) {
            $this->canceled_immediately = true;
        }

        if ($this->save()) {
            event(new SubscriptionCanceled($this));

            return $this;
        }

        return false;
    }

    /**
     * @param Plan $plan
     * @return Model
     * @throws \RafaelMorenoJS\Plans\Exceptions\InvalidIntervalException
     */
    public function changePlan(Plan $plan): Model
    {
        if (is_numeric($plan)) {
            $plan = App::make(PlanInterface::class)->find($plan);
        }

         // Si los planes no tienen la misma frecuencia de facturación
        //(por ejemplo, intervalo y intervalo_cuenta), actualizaremos las
        //fechas de facturación a partir de hoy ... y, básicamente, estamos
        //creando un nuevo ciclo de facturación, los datos de uso se borrarán.

        if (is_null($this->plan) or $this->plan->interval !== $plan->interval or
            $this->plan->interval_count !== $plan->interval_count) {
            // Set period
            $this->setNewPeriod($plan->interval, $plan->interval_count);
            // Clear usage data
            $usageManager = new SubscriptionUsageManager($this);
            $usageManager->clear();
        }

        // Attach new plan to subscription
        $this->plan_id = $plan->id;
        return $this;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $subscribable
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUser($query, $subscribable)
    {
        return $query->where('subscribable_id', $subscribable);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $dayRange
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindEndingTrial($query, $dayRange = 3)
    {
        $from = Carbon::now();
        $to = Carbon::now()->addDays($dayRange);

        return $query->whereBetween('trial_ends_at', [$from, $to]);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindEndedTrial($query)
    {
        return $query->where('trial_ends_at', '<=', date('Y-m-d H:i:s'));
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $dayRange
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindEndingPeriod($query, $dayRange = 3)
    {
        $from = Carbon::now();
        $to = Carbon::now()->addDays($dayRange);

        return $query->whereBetween('ends_at', [$from, $to]);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindEndedPeriod($query)
    {
        return $query->where('ends_at', '<=', date('Y-m-d H:i:s'));
    }
}
