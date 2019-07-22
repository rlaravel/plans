<?php

namespace RafaelMorenoJS\Plans\Contracts;

/**
 * Interface PlanSubscriptionUsageInterface
 * @package RafaelMorenoJS\Plans\Contracts
 */
interface PlanSubscriptionUsageInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feature(): \Illuminate\Database\Eloquent\Relations\BelongsTo;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription(): \Illuminate\Database\Eloquent\Relations\BelongsTo;

    /**
     * @param $query
     * @param $featureCode
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByFeatureCode($query, $featureCode): \Illuminate\Database\Eloquent\Builder;

    /**
     * @return bool
     */
    public function isExpired(): bool;
}
