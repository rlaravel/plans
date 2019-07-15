<?php

namespace RafaelMorenoJS\Plans\Models;

use Illuminate\Database\Eloquent\Model;
use RafaelMorenoJS\Plans\Contracts\PlanFeatureInterface;
use RafaelMorenoJS\Plans\Traits\BelongsToPlan;

/**
 * Class PlanFeature
 * @package RafaelMorenoJS\Plans\Models
 * @property-read int $id
 * @property int $plan_id
 * @property string $code
 * @property string $value
 * @property int $sort_order
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class PlanFeature extends Model implements PlanFeatureInterface
{
    use BelongsToPlan;

    /**
     * @var array
     */
    protected $fillable = [
        'plan_id', 'code', 'value', 'sort_order'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usage(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        // TODO: Implement usage() method.
    }
}