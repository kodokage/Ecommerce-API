<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('api_verification_code')->nullable()->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('category');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('gender')->nullable();
            $table->bigInteger('phone')->nullable();
            $table->bigInteger('phone_2')->nullable();
            $table->text('address')->nullable();
            $table->text('nearest_bustop')->nullable();
            $table->text('delivery_bus_park')->nullable();
            $table->string('business_name')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('isAdmin')->default(0);
            $table->boolean('isAgent')->default(0);
            $table->boolean('blocked')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
