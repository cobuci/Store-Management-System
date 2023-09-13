<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->id();
            $table->string('order_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->string('product_name');
            $table->string('product_brand')->nullable();
            $table->decimal('unit_cost', 10);
            $table->decimal('unit_price', 10);
            $table->string('weight');
            $table->integer('amount');
        });


        Schema::table('order', function ($table) {

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
};
