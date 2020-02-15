<?php

namespace MorenoRafael\Plans\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MorenoRafael\Plans\Contracts\PlanFeatureInterface;
use MorenoRafael\Plans\Models\Traits\CreatingUuidModel;
use MorenoRafael\Plans\Traits\BelongsToPlan;

/**
 * Class PlanFeature
 * @package MorenoRafael\Plans\Models
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
    use BelongsToPlan, CreatingUuidModel;

    /**
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * @var array
     */
    protected $fillable = [
        'uuid', 'plan_id', 'code', 'value', 'sort_order'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usage(): HasMany
    {
        // TODO: Implement usage() method.
    }
}
