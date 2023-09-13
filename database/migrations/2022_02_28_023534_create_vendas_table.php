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
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->integer('id_produto');
            $table->string('order_id')->nullable();
            $table->string('produto');
            $table->string('marca')->nullable();
            $table->integer('quantidade');
            $table->decimal('custo', 10);
            $table->decimal('precoUnidade', 10);
            $table->decimal('desconto', 10)->default(0)->nullable();
            $table->decimal('precoVenda', 10);
            $table->string('peso');
            $table->integer('id_cliente')->nullable();
            $table->string('nomeCliente')->nullable();
            $table->string('formaPagamento');
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
        Schema::dropIfExists('vendas');
    }
};
