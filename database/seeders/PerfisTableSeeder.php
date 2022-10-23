<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('perfis')->insert([
            'id' => 1,
            'ds_perfil' => 'Administrador Master',            
        ]);
        DB::table('perfis')->insert([
            'id' => 2,
            'ds_perfil' => 'Administrador Conteúdo',            
        ]);
        DB::table('perfis')->insert([
            'id' => 3,
            'ds_perfil' => 'Usuário',            
        ]);
    }
}
