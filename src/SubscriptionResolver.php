<?php

namespace RafaelMorenoJS\Plans;

use Illuminate\Database\Eloquent\Model;
use RafaelMorenoJS\Plans\Contracts\SubscriptionResolverInterface;

/**
 * Class SubscriptionResolver
 * @package RafaelMorenoJS\Plans
 */
class SubscriptionResolver implements SubscriptionResolverInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $subscribable
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function resolve(Model $subscribable, string $name): Model
    {
        $subscriptions = $subscribable->subscriptions->sortByDesc(function ($value) {
            return $value->created_at->getTimestamp();
        });

        foreach ($subscriptions as $key => $subscription) {
            if ($subscription->name === $name) {
                return $subscription;
            }
        }
    }
}
