<?php

namespace RLaravel\Plans\Exceptions;

use Exception;

/**
 * Class InvalidIntervalException
 * @package RLaravel\Plans\Exceptions
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