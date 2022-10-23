<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HandcapsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('handcaps')->insert([
            'id' => 1,
            'ds_handcap' => 'Grupo 1',
            'nr_pontuacao' => 100            
        ]);
        DB::table('handcaps')->insert([
            'id' => 2,
            'ds_handcap' => 'Grupo 2',
            'nr_pontuacao' => 93            
        ]);
        DB::table('handcaps')->insert([
            'id' => 3,
            'ds_handcap' => 'Grupo 3',
            'nr_pontuacao' => 85            
        ]);
        DB::table('handcaps')->insert([
            'id' => 4,
            'ds_handcap' => 'Grupo 4',
            'nr_pontuacao' => 75            
        ]);
        DB::table('handcaps')->insert([
            'id' => 5,
            'ds_handcap' => 'Grupo 5',
            'nr_pontuacao' => 65            
        ]);
        DB::table('handcaps')->insert([
            'id' => 6,
            'ds_handcap' => 'Grupo 6',
            'nr_pontuacao' => 50            
        ]);
        DB::table('handcaps')->insert([
            'id' => 7,
            'ds_handcap' => 'Grupo 7',
            'nr_pontuacao' => 35            
        ]);
        DB::table('handcaps')->insert([
            'id' => 8,
            'ds_handcap' => 'Grupo 8',
            'nr_pontuacao' => 20            
        ]);
        DB::table('handcaps')->insert([
            'id' => 9,
            'ds_handcap' => 'Grupo 9',
            'nr_pontuacao' => 10            
        ]);
        DB::table('handcaps')->insert([
            'id' => 10,
            'ds_handcap' => 'Grupo 10',
            'nr_pontuacao' => 5            
        ]);
    }
}
