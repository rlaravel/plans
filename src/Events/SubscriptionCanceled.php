<?php

namespace MorenoRafael\Plans\Events;

use Illuminate\Queue\SerializesModels;
use MorenoRafael\Plans\Models\PlanSubscription;

/**
 * Class SubscriptionCanceled
 * @package MorenoRafael\Plans\Events
 */
class SubscriptionCanceled
{
    use SerializesModels;

    /**
     * @var PlanSubscription
     */
    public $subscription;

    /**
     * SubscriptionCanceled constructor.
     * @param PlanSubscription $subscription
     */
    public function __construct(PlanSubscription $subscription)
    {
        $this->subscription = $subscription;
    }
}
