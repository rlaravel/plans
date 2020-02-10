<?php

namespace MorenoRafael\Plans\Contracts;

/**
 * Interface SubscriptionBuilderInterface
 * @package MorenoRafael\Plans\Contracts
 */
interface SubscriptionBuilderInterface
{
    /**
     * Especifique el período de duración de prueba en días.
     *
     * @param int $trialDays
     * @return mixed
     */
    public function trialDays(int $trialDays);

    /**
     * No aplique la versión de prueba a la suscripción.
     *
     * @return mixed
     */
    public function skipTrial();

    /**
     * Crear una nueva suscripción.
     *
     * @param array $attributes
     * @return \MorenoRafael\Plans\Models\PlanSubscription
     */
    public function create(array $attributes = []): \MorenoRafael\Plans\Models\PlanSubscription;
}