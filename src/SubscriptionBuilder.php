<?php

namespace RLaravel\Plans;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use RLaravel\Plans\Contracts\SubscriptionBuilderInterface;
use RLaravel\Plans\Models\PlanSubscription;
use Ramsey\Uuid\Uuid;

/**
 * Class SubscriptionBuilder
 * @package RLaravel\Plans
 */
class SubscriptionBuilder implements SubscriptionBuilderInterface
{
    /**
     * El modelo de usuario que se está suscribiendo.
     *
     * @var Model
     */
    protected $user;

    /**
     * TEl modelo de plan al que se suscribe el usuario.
     *
     * @var Model
     */
    protected $plan;

    /**
     * El nombre de la suscripción.
     *
     * @var string
     */
    protected $name;

    /**
     * Número personalizado de días de prueba para aplicar a la suscripción.
     * Esto anulará el período de prueba del plan.
     *
     * @var int|null
     */
    protected $trialDays;

    /**
     * No aplique la versión de prueba a la suscripción.
     *
     * @var bool
     */
    protected $skipTrial = false;

    /**
     * SubscriptionBuilder constructor.
     * @param Model $user
     * @param string $name
     * @param Model $plan
     */
    public function __construct(Model $user, string $name, Model $plan)
    {
        $this->user = $user;
        $this->name = $name;
        $this->plan = $plan;
    }

    /**
     * Especifique el período de duración de prueba en días.
     *
     * @param  int $trialDays
     * @return $this
     */
    public function trialDays($trialDays)
    {
        $this->trialDays = $trialDays;
        return $this;
    }

    /**
     * No aplique la versión de prueba a la suscripción.
     *
     * @return $this
     */
    public function skipTrial()
    {
        $this->skipTrial = true;
        return $this;
    }

    /**
     * @param array $attributes
     * @return PlanSubscription
     * @throws \Exception
     */
    public function create(array $attributes = []): PlanSubscription
    {
        $now = Carbon::now();

        if ($this->skipTrial) {
            $trialEndsAt = null;
        } elseif ($this->trialDays) {
            $trialEndsAt = ($this->trialDays ? $now->addDays($this->trialDays) : null);
        } elseif ($this->plan->hasTrial()) {
            $trialEndsAt = $now->addDays($this->plan->trial_period_days);
        } else {
            $trialEndsAt = null;
        }

        return $this->user->subscriptions()->create(array_replace([
            'uuid' => Uuid::uuid4(),
            'plan_id' => $this->plan->id,
            'trial_ends_at' => $trialEndsAt,
            'name' => $this->name
        ], $attributes));
    }
}
