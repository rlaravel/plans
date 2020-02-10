<?php

namespace MorenoRafael\Plans\Events;

use Illuminate\Queue\SerializesModels;
use MorenoRafael\Plans\Models\PlanSubscription;

/**
 * Class SubscriptionPlanChanged
 * @package MorenoRafael\Plans\Events
 */
class SubscriptionPlanChanged
{
    use SerializesModels;

    /**
     * @var PlanSubscription
     */
    public $subscription;

    /**
     * SubscriptionPlanChanged constructor.
     * @param PlanSubscription $subscription
     */
    public function __construct(PlanSubscription $subscription)
    {
        $this->subscription = $subscription;
    }
}
