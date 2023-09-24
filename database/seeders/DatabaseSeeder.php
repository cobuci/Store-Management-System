<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Finance;
use App\Models\Product;
use Database\Factories\CustomerFactory;
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

            SettingsSeeder::class,
            UserSeeder::class,
            CaixaSeeder::class,
            CategorizeSeeder::class,
        ]);

        Customer::factory(count: 100)->create();
        Product::factory(count: 200)->create();
    }
}
