<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('categorias')->insert([
            'nome' => "Água",
            'icone' => "local_drink",
            'classe' => "material-icons",
        ]);
        DB::table('categorias')->insert([
            'nome' => "Refrigerante",
            'icone' => "",
            'classe' => "fas fa-solid fa-whiskey-glass",
        ]);
        DB::table('categorias')->insert([
            'nome' => "Energético",
            'icone' => "",
            'classe' => "fas fa-solid fa-bolt",
        ]);
        DB::table('categorias')->insert([
            'nome' => "Cervejas (caixa)",
            'icone' => "",
            'classe' => "fas fa-box",
        ]);
        DB::table('categorias')->insert([
            'nome' => "Cervejas (unidade)",
            'icone' => "",
            'classe' => "fas fa-beer",
        ]);
        DB::table('categorias')->insert([
            'nome' => "Bebidas Alcoólicas",
            'icone' => "",
            'classe' => "fas fa-wine-bottle",
        ]);
        DB::table('categorias')->insert([
            'nome' => "Vinhos",
            'icone' => "",
            'classe' => "fas fa-wine-glass-alt",
        ]);
        DB::table('categorias')->insert([
            'nome' => "Comidas",
            'icone' => "",
            'classe' => "fas fa-hamburger",
        ]);
        DB::table('categorias')->insert([
            'nome' => "Kit",
            'icone' => "",
            'classe' => "fas fa-box-open",
        ]);
        DB::table('categorias')->insert([
            'nome' => "Outros",
            'icone' => "",
            'classe' => "fas fa-barcode",
        ]);
        DB::table('categorias')->insert([
            'nome' => "Bebidas",
            'icone' => "",
            'classe' => "fa-solid fa-bottle-droplet",
        ]);
        DB::table('categorias')->insert([
            'nome' => "Narguile",
            'icone' => "",
            'classe' => "fa-solid fa-smoking",
        ]);
        DB::table('categorias')->insert([
            'nome' => "Gelo",
            'icone' => "",
            'classe' => "fa-solid fa-icicles",
        ]);
    }
}
