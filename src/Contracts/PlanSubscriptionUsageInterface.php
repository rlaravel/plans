<?php

namespace RafaelMorenoJS\Plans\Contracts;

/**
 * Interface PlanSubscriptionUsageInterface
 * @package RafaelMorenoJS\Plans\Contracts
 */
interface PlanSubscriptionUsageInterface
{
    public function feature();

    public function subscription();

    public function scopeByFeatureCode($query, $featureCode);

    public function isExpired(): bool;
}