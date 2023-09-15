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
            'classe' => "fas fa-solid fa-droplet",
        ]);
        DB::table('categories')->insert([
            'nome' => "Refrigerante",
            'classe' => "fas fa-solid fa-whiskey-glass",
        ]);
        DB::table('categories')->insert([
            'nome' => "Energético",
            'classe' => "fas fa-solid fa-bolt",
        ]);
        DB::table('categories')->insert([
            'nome' => "Cervejas (caixa)",
            'classe' => "fas fa-box",
        ]);
        DB::table('categories')->insert([
            'nome' => "Cervejas (unidade)",
            'classe' => "fas fa-beer",
        ]);
        DB::table('categories')->insert([
            'nome' => "Bebidas Alcoólicas",
            'classe' => "fas fa-wine-bottle",
        ]);
        DB::table('categories')->insert([
            'nome' => "Vinhos",
            'classe' => "fas fa-wine-glass-alt",
        ]);
        DB::table('categories')->insert([
            'nome' => "Comidas",
            'classe' => "fas fa-hamburger",
        ]);
        DB::table('categories')->insert([
            'nome' => "Kit",
            'classe' => "fas fa-box-open",
        ]);
        DB::table('categories')->insert([
            'nome' => "Outros",
            'classe' => "fas fa-barcode",
        ]);
        DB::table('categories')->insert([
            'nome' => "Bebidas",
            'classe' => "fa-solid fa-martini-glass",
        ]);
        DB::table('categories')->insert([
            'nome' => "Narguile",
            'classe' => "fa-solid fa-smoking",
        ]);
        DB::table('categories')->insert([
            'nome' => "Gelo",

            'classe' => "fa-solid fa-icicles",
        ]);
        DB::table('categories')->insert([
            'nome' => "Doces",
            'classe' => "fa-solid fa-candy-cane",
        ]);
    }
}
