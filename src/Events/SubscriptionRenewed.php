<?php

namespace RLaravel\Plans\Events;

use Illuminate\Queue\SerializesModels;
use RLaravel\Plans\Models\PlanSubscription;

/**
 * Class SubscriptionRenewed
 * @package RLaravel\Plans\Events
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
