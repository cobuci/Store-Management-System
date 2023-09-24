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
            'name' => "Água",
            'icon' => "fas fa-solid fa-droplet",
        ]);
        DB::table('categories')->insert([
            'name' => "Refrigerante",
            'icon' => "fas fa-solid fa-whiskey-glass",
        ]);
        DB::table('categories')->insert([
            'name' => "Energético",
            'icon' => "fas fa-solid fa-bolt",
        ]);
        DB::table('categories')->insert([
            'name' => "Cervejas (caixa)",
            'icon' => "fas fa-box",
        ]);
        DB::table('categories')->insert([
            'name' => "Cervejas (unidade)",
            'icon' => "fas fa-beer",
        ]);
        DB::table('categories')->insert([
            'name' => "Bebidas Alcoólicas",
            'icon' => "fas fa-wine-bottle",
        ]);
        DB::table('categories')->insert([
            'name' => "Vinhos",
            'icon' => "fas fa-wine-glass-alt",
        ]);
        DB::table('categories')->insert([
            'name' => "Comidas",
            'icon' => "fas fa-hamburger",
        ]);
        DB::table('categories')->insert([
            'name' => "Kit",
            'icon' => "fas fa-box-open",
        ]);
        DB::table('categories')->insert([
            'name' => "Outros",
            'icon' => "fas fa-barcode",
        ]);
        DB::table('categories')->insert([
            'name' => "Bebidas",
            'icon' => "fa-solid fa-martini-glass",
        ]);
        DB::table('categories')->insert([
            'name' => "Narguile",
            'icon' => "fa-solid fa-smoking",
        ]);
        DB::table('categories')->insert([
            'name' => "Gelo",
            'icon' => "fa-solid fa-icicles",
        ]);
        DB::table('categories')->insert([
            'name' => "Doces",
            'icon' => "fa-solid fa-candy-cane",
        ]);
    }
}
