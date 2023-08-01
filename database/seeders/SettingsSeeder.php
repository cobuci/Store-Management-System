<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('settings')->insert([

            'descricao' => "Nome da empresa",
            'valor' => 'Teste',
        ]);

        DB::table('settings')->insert([

            'descricao' => "Quantidade de meses mostrado no grafico da dashboard",
            'valor' => 0,
        ]);
    }
}
