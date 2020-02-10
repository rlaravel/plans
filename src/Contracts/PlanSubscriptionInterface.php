<?php

namespace MorenoRafael\Plans\Contracts;

/**
 * Interface PlanSubscriptionInterface
 * @package MorenoRafael\Plans\Contracts
 */
interface PlanSubscriptionInterface
{
    /**
     * Consigue la suscripcion del modelo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscribable();

    /**
     * Conseguir plan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan();

    /**
     * Obtener el uso de suscripción.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usage();

    /**
     * Obtener el atributo de estado.
     *
     * @return string
     */
    public function getStatusAttribute(): string;

    /**
     * Compruebe si la suscripción está activa.
     *
     * @return bool
     */
    public function isActive(): bool;

    /**
     * Compruebe si la suscripción es de prueba.
     *
     * @return bool
     */
    public function onTrial(): bool;

    /**
     * Compruebe si la suscripción está cancelada.
     *
     * @return bool
     */
    public function isCanceled(): bool;

    /**
     * Compruebe si el período de suscripción ha terminado.
     *
     * @return bool
     */
    public function isEnded(): bool;

    /**
     * Renovar periodo de suscripción.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function renew(): \Illuminate\Database\Eloquent\Model;

    /**
     * Cancelar suscripción.
     *
     * @param bool $immediately
     * @return bool
     */
    public function cancel(bool $immediately): bool;

    /**
     * Cambiar plan de suscripción.
     *
     * @param \MorenoRafael\Plans\Models\Plan $plan
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function changePlan(\MorenoRafael\Plans\Models\Plan $plan): \Illuminate\Database\Eloquent\Model;
}
