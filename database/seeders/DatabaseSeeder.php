<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Seeder;

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
            UserSeeder::class,
            CashierSeeder::class,
            CategorizeSeeder::class,
        ]);

        Customer::factory(count: 100)->create();
        Product::factory(count: 200)->create();
    }
}
