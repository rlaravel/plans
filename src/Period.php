<?php

namespace RLaravel\Plans;

use Carbon\Carbon;
use RLaravel\Plans\Exceptions\InvalidIntervalException;

/**
 * Class Period
 * @package RLaravel\Plans
 */
class Period
{
    /**
     * The interval constants.
     */
    const DAY = 'day';
    const WEEK = 'week';
    const MONTH = 'month';
    const YEAR = 'year';

    /**
     * Map Interval to Carbon methods.
     *
     * @var array
     */
    protected static $intervalMapping = [
        self::DAY => 'addDays',
        self::WEEK => 'addWeeks',
        self::MONTH => 'addMonths',
        self::YEAR => 'addYears',
    ];

    /**
     * Starting date of the period.
     *
     * @var string
     */
    protected $start;

    /**
     * Ending date of the period.
     *
     * @var string
     */
    protected $end;

    /**
     * Interval
     *
     * @var string
     */
    protected $interval;

    /**
     * Interval count
     *
     * @var int
     */
    protected $interval_count = 1;

    /**
     * Create a new Period instance.
     *
     * @param string $interval
     * @param int $count
     * @param string $start
     * @throws \Throwable
     */
    public function __construct($interval = 'month', $count = 1, $start = '')
    {
        if (empty($start)) {
            $this->start = new Carbon();
        } elseif (! $start instanceof Carbon) {
            $this->start = new Carbon($start);
        } else {
            $this->start = $start;
        }

        throw_if(!$this::isValidInterval($interval), new InvalidIntervalException($interval));

        $this->interval = $interval;

        if ($count > 0) {
            $this->interval_count = $count;
        }

        $this->calculate();
    }

    /**
     * Get all available intervals.
     *
     * @return array
     */
    public static function getAllIntervals()
    {
        $intervals = [];
        foreach (array_keys(self::$intervalMapping) as $interval) {
            $intervals[$interval] = trans('laraplans::messages.'.$interval);
        }
        return $intervals;
    }

    /**
     * Get start date.
     *
     * @return Carbon|string
     */
    public function getStartDate()
    {
        return $this->start;
    }

    /**
     * Get end date.
     *
     * @return string
     */
    public function getEndDate()
    {
        return $this->end;
    }

    /**
     * Get period interval.
     *
     * @return string
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * Get period interval count.
     *
     * @return int
     */
    public function getIntervalCount()
    {
        return $this->interval_count;
    }

    /**
     * Check if a given interval is valid.
     *
     * @param $interval
     * @return bool
     */
    public static function isValidInterval($interval)
    {
        return array_key_exists($interval, self::$intervalMapping);
    }

    /**
     * Calculate the end date of the period.
     */
    protected function calculate()
    {
        $method = $this->getMethod();
        $start = clone($this->start);
        $this->end = $start->$method($this->interval_count);
    }

    /**
     * Get computation method.
     * 
     * @return mixed
     */
    protected function getMethod()
    {
        return self::$intervalMapping[$this->interval];
    }
}
