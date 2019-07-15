<?php

namespace RafaelMorenoJS\Plans\Contracts;

/**
 * Interface PlanFeatureInterface
 * @package RafaelMorenoJS\Plans\Contracts
 */
interface PlanFeatureInterface
{
    /**
     * Conseguir plan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan(): \Illuminate\Database\Eloquent\Relations\BelongsTo;

    /**
     * Obtener el uso de la función.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usage(): \Illuminate\Database\Eloquent\Relations\HasMany;
}