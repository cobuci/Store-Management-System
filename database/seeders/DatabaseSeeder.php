<?php

namespace Database\Seeders;

use App\Models\Financa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Int_;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
        // SALDO
        CaixaSeeder::class,
        // CATEGORIA    
        CategoriaSeeder::class,
        ]);
    }
}
