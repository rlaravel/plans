<?php

namespace RLaravel\Plans;

use Carbon\Carbon;
use RLaravel\Plans\Exceptions\InvalidPlanFeatureException;

/**
 * Class Feature
 * @package RLaravel\Plans
 */
class Feature
{
    /**
     * Feature code.
     *
     * @var string
     */
    protected $featureCode;

    /**
     * Feature resettable interval.
     *
     * @var string
     */
    protected $resettableInterval;

    /**
     * Feature resettable count.
     *
     * @var int
     */
    protected $resettableCount;

    /**
     * Create a new Feature instance.
     *
     * @param $featureCode
     * @throws \Throwable
     */
    public function __construct($featureCode)
    {
        throw_if(!self::isValid($featureCode), new InvalidPlanFeatureException($featureCode));

        $this->featureCode = $featureCode;
        $feature = config('plans.features.' . $featureCode);

        if (is_array($feature)) {
            foreach ($feature as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
    }

    /**
     * Get all features listed in config file.
     *
     * @return array
     */
    public static function getAllFeatures()
    {
        $features = config('plans.features');

        if (!$features) {
            return [];
        }

        $codes = [];
        foreach ($features as $key => $value) {
            if (is_string($value)) {
                $codes[] = $value;
            } else {
                $codes[] = $key;
            }
        }

        return $codes;
    }

    /**
     * Check if feature code is valid.
     *
     * @param $code
     * @return bool
     */
    public static function isValid($code)
    {
        $features = config('plans.features');

        if (array_key_exists($code, $features)) {
            return true;
        }

        if (in_array($code, $features)) {
            return true;
        }

        return false;
    }

    /**
     * Get feature code.
     *
     * @return string
     */
    public function getFeatureCode()
    {
        return $this->featureCode;
    }

    /**
     * Get resettable interval.
     *
     * @return string
     */
    public function getResettableInterval()
    {
        return $this->resettableInterval;
    }

    /**
     * Get resettable count.
     *
     * @return int
     */
    public function getResettableCount()
    {
        return $this->resettableCount;
    }

    /**
     * Set resettable interval.
     *
     * @param $interval
     */
    public function setResettableInterval($interval)
    {
        $this->resettableInterval = $interval;
    }

    /**
     * Set resettable count.
     *
     * @param $count
     */
    public function setResettableCount($count)
    {
        $this->resettableCount = $count;
    }

    /**
     * Check if feature is resettable.
     *
     * @return bool
     */
    public function isResettable()
    {
        return is_string($this->resettableInterval);
    }

    /**
     * @param  string  $dateFrom
     * @return string
     * @throws Exceptions\InvalidIntervalException
     */
    public function getResetDate($dateFrom = '')
    {
        if (empty($dateFrom)) {
            $dateFrom = new Carbon();
        }

        $period = new Period($this->resettableInterval, $this->resettableCount, $dateFrom);

        return $period->getEndDate();
    }
}
