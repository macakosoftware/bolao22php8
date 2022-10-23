<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GruposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grupos')->insert([
            'id' => 1,
            'ds_grupo' => 'Grupo A'            
        ]);
        DB::table('grupos')->insert([
            'id' => 2,
            'ds_grupo' => 'Grupo B'            
        ]);
        DB::table('grupos')->insert([
            'id' => 3,
            'ds_grupo' => 'Grupo C'            
        ]);
        DB::table('grupos')->insert([
            'id' => 4,
            'ds_grupo' => 'Grupo D'            
        ]);
        DB::table('grupos')->insert([
            'id' => 5,
            'ds_grupo' => 'Grupo E'            
        ]);
        DB::table('grupos')->insert([
            'id' => 6,
            'ds_grupo' => 'Grupo F'            
        ]);
        DB::table('grupos')->insert([
            'id' => 7,
            'ds_grupo' => 'Grupo G'            
        ]);
        DB::table('grupos')->insert([
            'id' => 8,
            'ds_grupo' => 'Grupo H'            
        ]);        
        DB::table('grupos')->insert([
            'id' => 9,
            'ds_grupo' => 'Sem Grupo'            
        ]);        
    }
}
