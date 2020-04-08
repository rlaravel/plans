<?php

namespace RLaravel\Plans\Events;

use Illuminate\Queue\SerializesModels;
use RLaravel\Plans\Models\PlanSubscription;

/**
 * Class SubscriptionCanceled
 * @package RLaravel\Plans\Events
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
