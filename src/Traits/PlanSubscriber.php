<?php

namespace RafaelMorenoJS\Plans\Traits;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\App;
use RafaelMorenoJS\Plans\Contracts\SubscriptionBuilderInterface;
use RafaelMorenoJS\Plans\Contracts\SubscriptionResolverInterface;
use RafaelMorenoJS\Plans\Models\Plan;
use RafaelMorenoJS\Plans\Models\PlanSubscription;
use RafaelMorenoJS\Plans\SubscriptionUsageManager;

/**
 * Trait PlanSubscriber
 * @package RafaelMorenoJS\Plans\Traits
 */
trait PlanSubscriber
{
    /**
     * Obtener una suscripción por nombre.
     *
     * @param string $name
     * @return \RafaelMorenoJS\Plans\Models\PlanSubscription|null
     */
    public function subscription(string $name = 'default')
    {
        return App::make(SubscriptionResolverInterface::class)->resolve($this, $name);
    }

    /**
     * Obtener la suscripción del plan de usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subscriptions()
    {
        return $this->morphMany(PlanSubscription::class, 'subscribable');
    }

    /**
     * Compruebe si el usuario tiene una suscripción determinada.
     *
     * @param string $subscription
     * @param int|null $planId
     * @return bool
     */
    public function subscribed(string $subscription = 'default', int $planId = null): bool
    {
        $subscription = $this->subscription();

        if (!is_null($subscription)) {
            return false;
        }

        if (is_null($planId)) {
            return $subscription->isActive();
        }

        if ($planId == $subscription->plan_id and $subscription->isActive()) {
            return true;
        }

        return false;
    }

    /**
     * Suscribir usuario a un nuevo plan.
     *
     * @param $subscription
     * @param $plan
     * @return Plan
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function newSubscription($subscription, $plan)
    {
        $container = Container::getInstance();
        if (method_exists($container, 'makeWith')) {
            return $container->makeWith(SubscriptionBuilderInterface::class, [
                'user' => $this, 'name' => $subscription, 'plan' => $plan
            ]);
        }
        return $container->make(SubscriptionBuilderInterface::class, [$this, $subscription, $plan]);
    }

    /**
     * Obtener instancia de administrador de uso de suscripción.
     *
     * @param  string $subscription
     * @return \RafaelMorenoJS\Plans\SubscriptionUsageManager
     */
    public function subscriptionUsage($subscription = 'default')
    {
        return new SubscriptionUsageManager($this->subscription($subscription));
    }
}
