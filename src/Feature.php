<?php

namespace RafaelMorenoJS\Plans;

use RafaelMorenoJS\Plans\Exceptions\InvalidPlanFeatureException;

/**
 * Class Feature
 * @package RafaelMorenoJS\Plans
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
     * @param string $featureCode
     * @throws  \RafaelMorenoJS\Plans\Exceptions\InvalidPlanFeatureException
     * @return void
     */
    public function __construct($featureCode)
    {
        if (!self::isValid($featureCode)) {
            throw new InvalidPlanFeatureException($featureCode);
        }

        $this->featureCode = $featureCode;
        $feature = config('laraplans.features.'.$featureCode);

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
        $features = config('laraplans.features');

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
     * @param string $code
     * @return bool
     */
    public static function isValid($code)
    {
        $features = [
            'SAMPLE_SIMPLE_FEATURE',
            'SAMPLE_DEFINED_FEATURE' => [
                'resettable_interval' => 'month',
                'resettable_count' => 2
            ],
        ];

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
     * @return string|null
     */
    public function getResettableInterval()
    {
        return $this->resettableInterval;
    }

    /**
     * Get resettable count.
     *
     * @return int|null
     */
    public function getResettableCount()
    {
        return $this->resettableCount;
    }

    /**
     * Set resettable interval.
     *
     * @param string
     * @return void
     */
    public function setResettableInterval($interval)
    {
        $this->resettableInterval = $interval;
    }

    /**
     * Set resettable count.
     *
     * @param int
     * @return void
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
     * Get feature's reset date.
     *
     * @param string $dateFrom
     * @return \Carbon\Carbon
     */
    public function getResetDate($dateFrom = '')
    {
        if (empty($dateFrom)) {
            $dateFrom = new Carbon;
        }
        $period = new Period($this->resettableInterval, $this->resettableCount, $dateFrom);
        return $period->getEndDate();
    }
}