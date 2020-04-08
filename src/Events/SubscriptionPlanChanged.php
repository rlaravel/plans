<?php

namespace RLaravel\Plans\Events;

use Illuminate\Queue\SerializesModels;
use RLaravel\Plans\Models\PlanSubscription;

/**
 * Class SubscriptionPlanChanged
 * @package RLaravel\Plans\Events
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
