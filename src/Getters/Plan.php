<?php

namespace MorenoRafael\Plans\Getters;

use MorenoRafael\Plans\Period;

/**
 * Trait Plan
 * @package MorenoRafael\Plans\Getters
 */
trait Plan
{
    /**
     * @return |null
     */
    public function getIntervalNameAttribute()
    {
        $intervals = Period::getAllIntervals();
        return (isset($intervals[$this->interval]) ? $intervals[$this->interval] : null);
    }

    /**
     * @return string
     */
    public function getIntervalDescriptionAttribute()
    {
        return trans_choice('plans::messages.interval_description.' . $this->interval, $this->interval_count);
    }
}
