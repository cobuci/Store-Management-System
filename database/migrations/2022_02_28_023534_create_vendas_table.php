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
            $table->string('produto');
            $table->string('marca');
            $table->integer('quantidade');
            $table->decimal('custo', 10, 2);
            $table->decimal('precoUnidade', 10, 2);
            $table->decimal('desconto', 10, 2);
            $table->decimal('precoVenda', 10, 2);
            $table->string('peso');
            $table->integer('id_cliente');
            $table->string('nomeCliente');
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
