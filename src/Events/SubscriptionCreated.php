<?php

namespace MorenoRafael\Plans\Events;

use Illuminate\Queue\SerializesModels;
use MorenoRafael\Plans\Models\PlanSubscription;

/**
 * Class SubscriptionCreated
 * @package MorenoRafael\Plans\Events
 */
class SubscriptionCreated
{
    use SerializesModels;

    /**
     * @var PlanSubscription
     */
    public $subscription;

    /**
     * SubscriptionCreated constructor.
     * @param PlanSubscription $subscription
     */
    public function __construct(PlanSubscription $subscription)
    {
        $this->subscription = $subscription;
    }
}
