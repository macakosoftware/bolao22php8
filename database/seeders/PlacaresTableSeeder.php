<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlacaresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('placares')->insert([
            'id' => 1,
            'ds_placar' => '1X0'
        ]);
        DB::table('placares')->insert([
            'id' => 2,
            'ds_placar' => '2X1'
        ]);
        DB::table('placares')->insert([
            'id' => 3,
            'ds_placar' => '2X0'
        ]);
        DB::table('placares')->insert([
            'id' => 4,
            'ds_placar' => '1X1'
        ]);
        DB::table('placares')->insert([
            'id' => 5,
            'ds_placar' => '0X0'
        ]);
        DB::table('placares')->insert([
            'id' => 6,
            'ds_placar' => '3X1'
        ]);
        DB::table('placares')->insert([
            'id' => 7,
            'ds_placar' => '3x2'
        ]);
        DB::table('placares')->insert([
            'id' => 8,
            'ds_placar' => '2X2'
        ]);
        DB::table('placares')->insert([
            'id' => 9,
            'ds_placar' => '4X1'
        ]);
        DB::table('placares')->insert([
            'id' => 10,
            'ds_placar' => '4X0'
        ]);
        DB::table('placares')->insert([
            'id' => 11,
            'ds_placar' => 'OUTROS'
        ]);
    }
}
