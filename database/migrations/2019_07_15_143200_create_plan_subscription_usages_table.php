<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanSubscriptionUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_subscription_usages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('subscription_id');
            $table->string('code');
            $table->unsignedSmallInteger('used');
            $table->timestamp('valid_until')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_subscription_usages');
    }
}
