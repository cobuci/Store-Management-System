<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('receipt_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cod');
            $table->string('price');
            $table->string('amount');
            $table->string('total');
            $table->boolean('active');
            $table->foreignId('receipt_list_id')->references('id')->on('receipt_lists');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt_items');
    }
};
