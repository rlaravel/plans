<?php

namespace MorenoRafael\Plans\Getters;

/**
 * Trait PlanSubscription
 * @package MorenoRafael\Plans\Getters
 */
trait PlanSubscription
{
    /**
     * @return string
     */
    public function getStatusAttribute(): string
    {
        if ($this->isActive()) {
            return self::STATUS_ACTIVE;
        }

        if ($this->isCanceled()) {
            return self::STATUS_CANCELED;
        }

        if ($this->isEnded()) {
            return self::STATUS_ENDED;
        }
    }
}
