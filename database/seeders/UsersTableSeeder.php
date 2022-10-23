<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Cleiton Machado Rieke',
            'email' => 'cleitonrieke@gmail.com',
            'password' => bcrypt('etcetc02'),
            'cd_perfil' => 1,
            'cd_pagamento' => 1,
            'vl_pagamento' => 0,
            'vl_premio' => 0       ,
        	'qt_pontos_xp' => 0
        ]);
    }
}
