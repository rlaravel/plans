<?php

namespace MorenoRafael\Plans\Exceptions;

use Exception;

/**
 * Class InvalidPlanFeatureException
 * @package MorenoRafael\Plans\Exceptions
 */
class InvalidPlanFeatureException extends Exception
{
    /**
     * Create a new InvalidPlanFeatureException instance.
     *
     * @param $feature
     * @return void
     */
    public function __construct($feature)
    {
        $this->message = "Invalid plan feature: {$feature}";
    }
}