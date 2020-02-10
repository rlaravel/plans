<?php

namespace MorenoRafael\Plans\Exceptions;

use Exception;

/**
 * Class FeatureValueFormatIncompatibleException
 * @package MorenoRafael\Plans\Exceptions
 */
class FeatureValueFormatIncompatibleException extends Exception
{
    /**
     * Create a new FeatureValueFormatIncompatibleException instance.
     *
     * @param $feature
     * @return void
     */
    public function __construct($feature)
    {
        $this->message = "Feature value format is incompatible: {$feature}.";
    }
}