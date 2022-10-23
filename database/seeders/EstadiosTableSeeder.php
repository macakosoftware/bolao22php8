<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadiosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estadios')->insert([
            'id' => 1,
            'ds_nome' => 'Estádio Al Thumama',
            'ds_foto' => 'al_thumama.jpg'            
        ]);
        DB::table('estadios')->insert([
            'id' => 2,
            'ds_nome' => 'Estádio Al Janoub',
            'ds_foto' => 'al_janoub.jpg' 
        ]);
        DB::table('estadios')->insert([
            'id' => 3,
            'ds_nome' => 'Estádio Al Bayt',
            'ds_foto' => 'al_bayt.jpg' 
        ]);
        DB::table('estadios')->insert([
            'id' => 4,
            'ds_nome' => 'Estádio Ahmad bin Ali',
            'ds_foto' => 'ahmad_bin_ali.jpg'            
        ]);
        DB::table('estadios')->insert([
            'id' => 5,
            'ds_nome' => 'Estádio Cidade da Educação',
            'ds_foto' => 'education_city.jpg'            
        ]);
        DB::table('estadios')->insert([
            'id' => 6,
            'ds_nome' => 'Estádio 974',
            'ds_foto' => 'estadio_974.jpg'            
        ]);
        DB::table('estadios')->insert([
            'id' => 7,
            'ds_nome' => 'Estádio Internacional Khalifa',
            'ds_foto' => 'khalifa_stadium.jpg'            
        ]);
        DB::table('estadios')->insert([
            'id' => 8,
            'ds_nome' => 'Estádio Lusail',
            'ds_foto' => 'lusail.jpg'            
        ]);        
    }
}
