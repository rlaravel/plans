<?php

namespace RafaelMorenoJS\Plans\Exceptions;

use Exception;

/**
 * Class InvalidIntervalException
 * @package RafaelMorenoJS\Plans\Exceptions
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