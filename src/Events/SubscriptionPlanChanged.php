<?php

namespace RafaelMorenoJS\Plans\Events;

use Illuminate\Queue\SerializesModels;
use RafaelMorenoJS\Plans\Models\PlanSubscription;

/**
 * Class SubscriptionPlanChanged
 * @package RafaelMorenoJS\Plans\Events
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
