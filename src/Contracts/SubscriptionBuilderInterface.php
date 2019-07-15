<?php

namespace RafaelMorenoJS\Plans\Contracts;

/**
 * Interface SubscriptionBuilderInterface
 * @package RafaelMorenoJS\Plans\Contracts
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
     * @return \RafaelMorenoJS\Plans\Models\PlanSubscription
     */
    public function create(array $attributes = []): \RafaelMorenoJS\Plans\Models\PlanSubscription;
}