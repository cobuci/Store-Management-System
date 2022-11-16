<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaixaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('caixas')->insert([
            'id' => 1,
            'descricao' => "Saldo",
            'saldo' => 0,
        ]);

        DB::table('caixas')->insert([

            'id' => 2,
            'descricao' => "Investimento",
            'saldo' => 0,
        ]);

        DB::table('caixas')->insert([
            'id' => 3,
            'descricao' => "Ifood",
            'saldo' => 0
        ]);

        DB::table('caixas')->insert([
            'id' => 4,
            'descricao' => "Meta",
            'saldo' => 0
        ]);
       
    }
}
