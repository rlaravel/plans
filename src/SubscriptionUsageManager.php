<?php

namespace RLaravel\Plans;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SubscriptionUsageManager
 * @package RLaravel\Plans
 */
class SubscriptionUsageManager
{
    /**
     * Instancia de modelo de suscripción.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $subscription;

    /**
     * Crear una nueva instancia de Gestor de uso de suscripción.
     *
     * @param \Illuminate\Database\Eloquent\Model $subscription
     */
    public function __construct(Model $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Registro de uso.
     *
     * @param $feature
     * @param int $uses
     * @param bool $incremental
     * @return mixed
     * @throws Exceptions\InvalidIntervalException
     * @throws \Throwable
     */
    public function record($feature, $uses = 1, $incremental = true)
    {
        $feature = new Feature($feature);

        $usage = $this->subscription->usage()->firstOrNew([
            'code' => $feature->getFeatureCode(),
        ]);

        if ($feature->isResettable()) {
            if (is_null($usage->valid_until)) {
                $usage->valid_until = $feature->getResetDate($this->subscription->created_at);
            } elseif ($usage->isExpired() === true) {
                $usage->valid_until = $feature->getResetDate($usage->valid_until);
                $usage->used = 0;
            }
        }

        $usage->used = ($incremental ? $usage->used + $uses : $uses);
        $usage->save();

        return $usage;
    }

    /**
     * Reducir el uso.
     *
     * @param $feature
     * @param int $uses
     * @return bool
     * @throws \Throwable
     */
    public function reduce($feature, $uses = 1)
    {
        $feature = new Feature($feature);

        $usage = $this->subscription
            ->usage()
            ->byFeatureCode($feature->getFeatureCode())
            ->first();

        if (is_null($usage)) {
            return false;
        }

        $usage->used = max($usage->used - $uses, 0);
        $usage->save();

        return $usage;
    }

    /**
     * Borrar datos de uso.
     *
     * @return $this
     */
    public function clear()
    {
        $this->subscription->usage()->delete();

        return $this;
    }
}
