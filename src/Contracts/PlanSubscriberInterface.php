<?php

namespace RafaelMorenoJS\Plans\Contracts;

/**
 * Interface PlanSubscriberInterface
 * @package RafaelMorenoJS\Plans\Contracts
 */
interface PlanSubscriberInterface
{
    public function subscription(string $name = 'default');

    public function subscriptions();

    public function subscribed(string $subscription = 'default');

    public function newSubscription($name, $plan);

    public function subscriptionUsage(string $subscription = 'default');
}