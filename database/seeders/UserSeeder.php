<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => 0,
            'name' => "Teste",
            'email' => 'teste@teste.com',
            'password' => '$2a$12$zE7SXtHrR1uAoHIqiExGM.RorKV2NqcpuA5uRRyRRmw9hTrco0ALu', // teste
        ]);
    }
}
