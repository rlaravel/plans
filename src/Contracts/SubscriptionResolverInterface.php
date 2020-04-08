<?php

namespace RLaravel\Plans\Contracts;

/**
 * Interface SubscriptionResolverInterface
 * @package RLaravel\Plans\Contracts
 */
interface SubscriptionResolverInterface
{
    /**
     * Resolver la suscripción suscribible.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $subscribable
     * @param  string  $name
     * @return mixed
     */
    public function resolve(\Illuminate\Database\Eloquent\Model $subscribable, string $name);
}