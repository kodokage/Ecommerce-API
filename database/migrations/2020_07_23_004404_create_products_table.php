<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('business_name');
            $table->string('name');
            $table->string('category');
            $table->bigInteger('unit_price');
            $table->text('description');
            $table->bigInteger('max_unit');
            $table->bigInteger('min_unit');
            $table->string('ref');
            $table->boolean('status')->default(0);
            $table->boolean('authorized')->default(0);
            $table->bigInteger('quantity');
            $table->string('img1');
            $table->string('img2');
            $table->string('img3');
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
        Schema::dropIfExists('products');
    }
}
