<?php

namespace RafaelMorenoJS\Plans\Events;

use Illuminate\Queue\SerializesModels;
use RafaelMorenoJS\Plans\Models\PlanSubscription;

/**
 * Class SubscriptionCreated
 * @package RafaelMorenoJS\Plans\Events
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
