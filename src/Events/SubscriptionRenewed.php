<?php

namespace RafaelMorenoJS\Plans\Events;

use Illuminate\Queue\SerializesModels;
use RafaelMorenoJS\Plans\Models\PlanSubscription;

/**
 * Class SubscriptionRenewed
 * @package RafaelMorenoJS\Plans\Events
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
