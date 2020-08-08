<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnboardUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onboard_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('gender');
            $table->bigInteger('phone');
            $table->bigInteger('phone_2');
            $table->text('address');
            $table->text('nearest_bustop');
            $table->text('delivery_bus_park');
            $table->string('business_name');
            $table->string('image');
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
        Schema::dropIfExists('onboard_users');
    }
}
