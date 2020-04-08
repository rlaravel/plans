<?php

namespace RLaravel\Plans\Events;

use Illuminate\Queue\SerializesModels;
use RLaravel\Plans\Models\PlanSubscription;

/**
 * Class SubscriptionCreated
 * @package RLaravel\Plans\Events
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
