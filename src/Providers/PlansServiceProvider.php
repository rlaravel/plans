<?php

namespace RLaravel\Plans\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use RLaravel\Plans\Contracts\PlanFeatureInterface;
use RLaravel\Plans\Contracts\PlanInterface;
use RLaravel\Plans\Contracts\PlanSubscriptionInterface;
use RLaravel\Plans\Contracts\PlanSubscriptionUsageInterface;
use RLaravel\Plans\Contracts\SubscriptionBuilderInterface;
use RLaravel\Plans\Contracts\SubscriptionResolverInterface;
use RLaravel\Plans\Models\Plan;
use RLaravel\Plans\Models\PlanFeature;
use RLaravel\Plans\Models\PlanSubscription;
use RLaravel\Plans\Models\PlanSubscriptionUsage;
use RLaravel\Plans\SubscriptionBuilder;
use RLaravel\Plans\SubscriptionResolver;

/**
 * Class PlansServiceProvider
 * @package RLaravel\Plans\Providers
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
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/plans.php', 'plans'
        );

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
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadFactoriesFrom(__DIR__ . '/../../database/factories');

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
