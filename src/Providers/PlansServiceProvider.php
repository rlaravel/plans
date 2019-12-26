<?php

namespace RafaelMorenoJS\Plans\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use RafaelMorenoJS\Plans\Contracts\PlanFeatureInterface;
use RafaelMorenoJS\Plans\Contracts\PlanInterface;
use RafaelMorenoJS\Plans\Contracts\PlanSubscriptionInterface;
use RafaelMorenoJS\Plans\Contracts\PlanSubscriptionUsageInterface;
use RafaelMorenoJS\Plans\Contracts\SubscriptionBuilderInterface;
use RafaelMorenoJS\Plans\Contracts\SubscriptionResolverInterface;
use RafaelMorenoJS\Plans\Models\Plan;
use RafaelMorenoJS\Plans\Models\PlanFeature;
use RafaelMorenoJS\Plans\Models\PlanSubscription;
use RafaelMorenoJS\Plans\Models\PlanSubscriptionUsage;
use RafaelMorenoJS\Plans\SubscriptionBuilder;
use RafaelMorenoJS\Plans\SubscriptionResolver;

/**
 * Class PlansServiceProvider
 * @package RafaelMorenoJS\Plans\Providers
 */
class PlansServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PlanInterface::class, Plan::class);
        $this->app->bind(PlanFeatureInterface::class, PlanFeature::class);
        $this->app->bind(PlanSubscriptionInterface::class, PlanSubscription::class);
        $this->app->bind(PlanSubscriptionUsageInterface::class, PlanSubscriptionUsage::class);
        $this->app->bind(SubscriptionBuilderInterface::class, SubscriptionBuilder::class);
        $this->app->bind(SubscriptionResolverInterface::class, SubscriptionResolver::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/plans.php' => config_path('plans.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->bladeDirectives();
    }

    /**
     *
     */
    protected function bladeDirectives()
    {
        Blade::if('plansubscribed', function () {
            return auth()->user()->subscribed('main');
        });

        Blade::if('planactive', function () {
            return auth()->user()->subscription('main')->isActive();
        });

        Blade::if('plancanceled', function () {
            return auth()->user()->subscription('main')->isCanceled();
        });

        Blade::if('plancanceledimmediately', function () {
            return auth()->user()->subscription('main')->isCanceledImmediately();
        });

        Blade::if('planended', function () {
            return auth()->user()->subscription('main')->isEnded();
        });

        Blade::if('plantrial', function () {
            return auth()->user()->subscription('main')->onTrial();
        });
    }
}
