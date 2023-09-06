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
            $table->string('produto');
            $table->string('marca')->nullable();
            $table->decimal('custoUnidade', 10, 2);
            $table->decimal('precoUnidade', 10, 2);
            $table->string('peso');
            $table->integer('quantidade');
            $table->integer('status_pagamento');
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
