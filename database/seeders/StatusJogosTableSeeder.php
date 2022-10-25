<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusJogosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_jogos')->insert([
            'id' => 1,
            'ds_status' => 'Programado'
        ]);
        DB::table('status_jogos')->insert([
            'id' => 2,
            'ds_status' => 'Finalizado'
        ]);
        DB::table('status_jogos')->insert([
            'id' => 3,
            'ds_status' => 'Previsto'
        ]);
        DB::table('status_jogos')->insert([
            'id' => 4,
            'ds_status' => 'Aposta Encerrada'
        ]);
    }
}
