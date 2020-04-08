<?php

namespace RLaravel\Plans\Contracts;

/**
 * Interface PlanInterface
 * @package RLaravel\Plans\Contracts
 */
interface PlanInterface
{
    /**
     * Obtener características del plan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function features(): \Illuminate\Database\Eloquent\Relations\HasMany;

    /**
     * Obtenga suscripciones al plan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions(): \Illuminate\Database\Eloquent\Relations\HasMany;

    /**
     * Compruebe si el plan es gratuito.
     *
     * @return bool
     */
    public function isFree(): bool;

    /**
     * Compruebe si el plan es prueba.
     *
     * @return bool
     */
    public function hasTrial(): bool;
}