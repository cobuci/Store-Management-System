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
            $table->decimal('custo', 10, 2);
            $table->decimal('desconto', 10, 2)->default(0)->nullable();
            $table->decimal('precoVenda', 10, 2);
            $table->integer('id_cliente')->nullable();
            $table->string('nomeCliente')->nullable();
            $table->string('formaPagamento');
            $table->timestamps();
            $table->string('status_pagamento');
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
