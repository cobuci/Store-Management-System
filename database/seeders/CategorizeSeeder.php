<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('categories')->insert([
            'nome' => "Água",
            'icone' => "local_drink",
            'classe' => "material-icons",
        ]);
        DB::table('categories')->insert([
            'nome' => "Refrigerante",
            'icone' => "",
            'classe' => "fas fa-solid fa-whiskey-glass",
        ]);
        DB::table('categories')->insert([
            'nome' => "Energético",
            'icone' => "",
            'classe' => "fas fa-solid fa-bolt",
        ]);
        DB::table('categories')->insert([
            'nome' => "Cervejas (caixa)",
            'icone' => "",
            'classe' => "fas fa-box",
        ]);
        DB::table('categories')->insert([
            'nome' => "Cervejas (unidade)",
            'icone' => "",
            'classe' => "fas fa-beer",
        ]);
        DB::table('categories')->insert([
            'nome' => "Bebidas Alcoólicas",
            'icone' => "",
            'classe' => "fas fa-wine-bottle",
        ]);
        DB::table('categories')->insert([
            'nome' => "Vinhos",
            'icone' => "",
            'classe' => "fas fa-wine-glass-alt",
        ]);
        DB::table('categories')->insert([
            'nome' => "Comidas",
            'icone' => "",
            'classe' => "fas fa-hamburger",
        ]);
        DB::table('categories')->insert([
            'nome' => "Kit",
            'icone' => "",
            'classe' => "fas fa-box-open",
        ]);
        DB::table('categories')->insert([
            'nome' => "Outros",
            'icone' => "",
            'classe' => "fas fa-barcode",
        ]);
        DB::table('categories')->insert([
            'nome' => "Bebidas",
            'icone' => "",
            'classe' => "fa-solid fa-martini-glass",
        ]);
        DB::table('categories')->insert([
            'nome' => "Narguile",
            'icone' => "",
            'classe' => "fa-solid fa-smoking",
        ]);
        DB::table('categories')->insert([
            'nome' => "Gelo",
            'icone' => "",
            'classe' => "fa-solid fa-icicles",
        ]);
        DB::table('categories')->insert([
            'nome' => "Doces",
            'icone' => "",
            'classe' => "fa-solid fa-candy-cane",
        ]);
    }
}
