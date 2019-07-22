<?php

namespace RafaelMorenoJS\Plans\Events;

use Illuminate\Queue\SerializesModels;
use RafaelMorenoJS\Plans\Models\PlanSubscription;

/**
 * Class SubscriptionCanceled
 * @package RafaelMorenoJS\Plans\Events
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
