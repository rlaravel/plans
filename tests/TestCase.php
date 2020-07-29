<?php

namespace RLaravel\Plans\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use RLaravel\Plans\Providers\PlansServiceProvider;

/**
 * Class TestCase
 * @package RLaravel\Plans\Tests
 */
class TestCase extends BaseTestCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [PlansServiceProvider::class];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('plan.positive_words', ['Y', 'YES', 'TRUE', 'UNLIMITED']);
        $app['config']->set('plan.features', [
            'SAMPLE_SIMPLE_FEATURE',
            'SAMPLE_DEFINED_FEATURE' => [
                'resettable_interval' => 'month',
                'resettable_count' => 2
            ],
        ]);

        $app['config']->set('database.default', 'mysql');
        $app['config']->set('database.connections.mysql', [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'database' => 'packages_rlaravel_plans',
            'username' => 'rafael',
            'password' => '1234'
        ]);
    }
}