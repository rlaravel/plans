<?php

namespace RLaravel\Plans\Contracts;

/**
 * Interface SubscriptionBuilderInterface
 * @package RLaravel\Plans\Contracts
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
     * @return \RLaravel\Plans\Models\PlanSubscription
     */
    public function create(array $attributes = []): \RLaravel\Plans\Models\PlanSubscription;
}