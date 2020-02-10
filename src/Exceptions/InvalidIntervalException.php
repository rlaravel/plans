<?php

namespace MorenoRafael\Plans\Exceptions;

use Exception;

/**
 * Class InvalidIntervalException
 * @package MorenoRafael\Plans\Exceptions
 */
class InvalidIntervalException extends Exception
{
    /**
     * Create a new InvalidPlanFeatureException instance.
     *
     * @param $interval
     * @return void
     */
    public function __construct($interval)
    {
        $this->message = "Invalid interval \"{$interval}\".";
    }
}