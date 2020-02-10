<?php

namespace MorenoRafael\Plans\Contracts;

/**
 * Interface SubscriptionResolverInterface
 * @package MorenoRafael\Plans\Contracts
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