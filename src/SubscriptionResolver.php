<?php

namespace RLaravel\Plans;

use Illuminate\Database\Eloquent\Model;
use RLaravel\Plans\Contracts\SubscriptionResolverInterface;

/**
 * Class SubscriptionResolver
 * @package RLaravel\Plans
 */
class SubscriptionResolver implements SubscriptionResolverInterface
{
    /**
     * @param  Model  $subscribable
     * @param  string  $name
     * @return Model
     */
    public function resolve(Model $subscribable, string $name)
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
