<?php

namespace MorenoRafael\Plans\Traits;

use MorenoRafael\Plans\Models\Plan;

/**
 * Trait BelongsToPlan
 * @package MorenoRafael\Plans\Traits
 */
trait BelongsToPlan
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
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
