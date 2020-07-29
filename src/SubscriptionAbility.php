<?php

namespace RLaravel\Plans;

/**
 * Class SubscriptionAbility
 * @package RLaravel\Plans
 */
class SubscriptionAbility
{
    /**
     * Subscription model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $subscription;

    /**
     * Create a new Subscription instance.
     *
     * SubscriptionAbility constructor.
     * @param $subscription
     */
    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Determina si la característica está habilitada y tiene usos disponibles.
     *
     * @param $feature
     * @return bool
     */
    public function canUse($feature)
    {
        // Obtén características y uso
        $featureValue = $this->value($feature);
        if (is_null($featureValue)) {
            return false;
        }
        // Coincide con el valor de tipo "booleano"
        if ($this->enabled($feature) === true) {
            return true;
        }

        if (!$this->useIsAvailable($featureValue)) {
            return false;
        }

        // Consultar usos disponibles.
        return $this->remainings($feature) > 0;
    }

    /**
     * Obtenga cuántas veces se ha utilizado la función.
     *
     * @param $feature
     * @return int
     */
    public function consumed($feature)
    {
        foreach ($this->subscription->usage as $key => $usage) {
            if ($usage->code === $feature and $usage->isExpired() == false) {
                return $usage->used;
            }
        }
        return 0;
    }

    /**
     * Consigue los usos disponibles.
     *
     * @param $feature
     * @return int
     */
    public function remainings($feature)
    {
        return ((int) $this->value($feature) - (int) $this->consumed($feature));
    }

    /**
     * Compruebe si la función de plan de suscripción está habilitada.
     *
     * @param $feature
     * @return bool
     */
    public function enabled($feature)
    {
        $featureValue = $this->value($feature);
        if (is_null($featureValue)) {
            return false;
        }

        // Si el valor es una de las palabras positivas configuradas,
        // entonces la función está habilitada.
        if ($this->isPositiveWord($featureValue)) {
            return true;
        }

        return false;
    }

    /**
     * Obtener valor de la característica.
     *
     * @param  string $feature
     * @param  mixed $default
     * @return mixed
     */
    public function value($feature, $default = null)
    {
        foreach ($this->subscription->plan->features as $key => $value) {
            if ($feature === $value->code) {
                return $value->value;
            }
        }

        return $default;
    }

    /**
     * @param $featureValue
     * @return bool
     */
    protected function useIsAvailable($featureValue)
    {
        if ($featureValue === '0') {
            return false;
        }

        return true;
    }

    /**
     * @param $featureValue
     * @return bool
     */
    protected function isPositiveWord($featureValue)
    {
        if (in_array(strtoupper($featureValue), config('plans.positive_words'))) {
            return true;
        }

        return false;
    }
}
