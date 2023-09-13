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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->decimal('cost', 10);
            $table->decimal('discount', 10)->default(0)->nullable();
            $table->decimal('price', 10);
            $table->integer('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('payment_method');
            $table->string('payment_status')->default(0)->nullable();
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
        Schema::dropIfExists('sales');
    }
};
