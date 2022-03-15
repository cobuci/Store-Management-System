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
        Schema::create('financas', function (Blueprint $table) {
            $table->id();
            $table->decimal('valor',10,2);
            $table->integer('id_produto');
            $table->integer('quantidade');
            $table->string('descricao');
            $table->string('tipo');         
            $table->timestamp('data');                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('financas');
    }
};
