<?php

namespace MorenoRafael\Plans\Events;

use Illuminate\Queue\SerializesModels;
use MorenoRafael\Plans\Models\PlanSubscription;

/**
 * Class SubscriptionRenewed
 * @package MorenoRafael\Plans\Events
 */
class SubscriptionRenewed
{
    use SerializesModels;

    /**
     * @var PlanSubscription
     */
    public $subscription;

    /**
     * SubscriptionRenewed constructor.
     * @param PlanSubscription $subscription
     */
    public function __construct(PlanSubscription $subscription)
    {
        $this->subscription = $subscription;
    }
}
