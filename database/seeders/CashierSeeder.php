<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CashierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cashiers')->insert([
            'description' => "Saldo",
            'balance' => 0,
        ]);

        DB::table('cashiers')->insert([
            'description' => "Investimento",
            'balance' => 0,
        ]);

        DB::table('cashiers')->insert([
            'description' => "Meta",
            'balance' => 0
        ]);

    }
}
