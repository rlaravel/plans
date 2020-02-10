<?php

namespace MorenoRafael\Plans\Contracts;

/**
 * Interface PlanSubscriberInterface
 * @package MorenoRafael\Plans\Contracts
 */
interface PlanSubscriberInterface
{
    /**
     * @param string $name
     * @return mixed
     */
    public function subscription(string $name);

    /**
     * @return mixed
     */
    public function subscriptions();

    /**
     * @param string $subscription
     * @return mixed
     */
    public function subscribed(string $subscription);

    /**
     * @param $name
     * @param $plan
     * @return mixed
     */
    public function newSubscription($name, $plan);

    /**
     * @param string $subscription
     * @return mixed
     */
    public function subscriptionUsage(string $subscription);
}
