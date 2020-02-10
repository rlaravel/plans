<?php

namespace MorenoRafael\Plans\Contracts;

/**
 * Interface PlanFeatureInterface
 * @package MorenoRafael\Plans\Contracts
 */
interface PlanFeatureInterface
{
    /**
     * Conseguir plan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan();

    /**
     * Obtener el uso de la función.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usage();
}