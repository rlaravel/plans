<?php

namespace RafaelMorenoJS\Plans\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use RafaelMorenoJS\Plans\Contracts\PlanSubscriptionUsageInterface;

/**
 * Class PlanSubscriptionUsage
 * @package RafaelMorenoJS\Plans\Models
 * @property-read int $id
 * @property int $subscription_id
 * @property string $code
 * @property bool $used
 * @property \Carbon\Carbon $valid_until
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @mixin Eloquent
 */
class PlanSubscriptionUsage extends Model implements PlanSubscriptionUsageInterface
{
    /**
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * @var array
     */
    protected $fillable = [
        'subscription_id', 'code', 'used', 'valid_until'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'valid_until',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function feature(): BelongsTo
    {
        return $this->belongsTo(PlanFeature::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(PlanSubscription::class);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $featureCode
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByFeatureCode($query, $featureCode): Builder
    {
        return $query->whereCode($featureCode);
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        if (!is_null($this->valid_until)) {
            return false;
        }

        return Carbon::now()->gt($this->valid_until) or Carbon::now()->eq($this->valid_until);
    }
}
