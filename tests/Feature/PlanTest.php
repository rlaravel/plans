<?php

namespace RLaravel\Plans\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use RLaravel\Plans\Models\Plan;
use RLaravel\Plans\Models\PlanFeature;
use RLaravel\Plans\Tests\TestCase;

/**
 * Class PlanTest
 * @package RLaravel\Plans\Tests\Feature
 */
class PlanTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Poder crear un plan
     *
     * @test
     */
    public function can_create_a_plan()
    {
        // 1. Given
        $data = ['name' => 'Pro', 'description' => 'Pro plan', 'price' => 9.99, 'interval' => 'month',
            'interval_count' => 1, 'trial_period_days' => 15, 'sort_order' => 1];

        // 2. When
        Plan::create($data);

        // 3. Then
        $this->assertDatabaseHas('plans', $data);
    }

    /**
     * Poder agregar características al plan
     *
     * @test
     */
    public function can_add_features_to_the_plan()
    {
        // 1. Given
        $plan = factory(Plan::class)->create();

        // 2. When
        $plan->features()->saveMany([
            new PlanFeature(['code' => 'listings', 'value' => 50, 'sort_order' => 1]),
            new PlanFeature(['code' => 'pictures_per_listing', 'value' => 10, 'sort_order' => 5]),
            new PlanFeature(['code' => 'listing_duration_days', 'value' => 30, 'sort_order' => 10]),
            new PlanFeature(['code' => 'listing_title_bold', 'value' => 'Y', 'sort_order' => 15])
        ]);

        // 3. Then
        $this->assertDatabaseHas('plan_features', ['code' => 'listings', 'value' => 50, 'sort_order' => 1]);
        $this->assertDatabaseHas('plan_features', ['code' => 'pictures_per_listing', 'value' => 10, 'sort_order' => 5]);
        $this->assertDatabaseHas('plan_features', ['code' => 'listing_duration_days', 'value' => 30, 'sort_order' => 10]);
        $this->assertDatabaseHas('plan_features', ['code' => 'listing_title_bold', 'value' => 'Y', 'sort_order' => 15]);
    }

    /**
     * Poder acceder a las características del plan
     *
     * @test
     */
    public function can_access_plan_features()
    {
        // 1. Given
        $plan = factory(Plan::class)->create();
        $plan->features()->saveMany([
            new PlanFeature(['code' => 'pictures_per_listing', 'value' => 10, 'sort_order' => 5])
        ]);

        // 2. When
        $feature = $plan->getFeatureByCode('pictures_per_listing');

        // 3. Then
        $this->assertSame('10', $feature->value);
    }
}