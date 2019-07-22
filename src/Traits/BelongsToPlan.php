<?php

namespace RafaelMorenoJS\Plans\Traits;

use RafaelMorenoJS\Plans\Models\Plan;

/**
 * Trait BelongsToPlan
 * @package RafaelMorenoJS\Plans\Traits
 */
trait BelongsToPlan
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $plan_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByPlan($query, $plan_id)
    {
        return $query->where('plan_id', $plan_id);
    }
}
