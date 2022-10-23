<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposRankingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_rankings')->insert([
            'id' => 1,
            'ds_nome' => 'Primeira Fase - Primeira Rodada',
            'dt_limite' => '2022-11-19',
            'hr_limite' => '21:00',
            'cd_status' => 1,
        	'qt_apostas' => 0,
        	'tp_fase' => 'S',
        	'ds_badge' => '',
        	'id_handicap_casa' => false, 
        	'tp_serie' => '',
        	'ds_abreviado' => '1a.Rodada',
        	'pc_premio1' => 0,	
        	'pc_premio2' => 0,	
        	'pc_premio3' => 0,	
        		'id_grupo' => 1,
        ]);
        DB::table('tipos_rankings')->insert([
            'id' => 2,
            'ds_nome' => 'Primeira Fase - Segunda Rodada',
            'dt_limite' => '2022-11-24',
            'hr_limite' => '21:00',
            'cd_status' => 1,
        		'qt_apostas' => 0,
        		'tp_fase' => 'S',
        		'ds_badge' => '',
        		'id_handicap_casa' => false,
        		'tp_serie' => '',
        		'ds_abreviado' => '2a.Rodada',
        		'pc_premio1' => 0,
        		'pc_premio2' => 0,
        		'pc_premio3' => 0,	
        		'id_grupo' => 1,
        ]);
        DB::table('tipos_rankings')->insert([
            'id' => 3,
            'ds_nome' => 'Primeira Fase - Terceira Rodada',
            'dt_limite' => '2022-11-28',
            'hr_limite' => '21:00',
            'cd_status' => 1,
        		'qt_apostas' => 0,
        		'tp_fase' => 'S',
        		'ds_badge' => '',
        		'id_handicap_casa' => false,
        		'tp_serie' => '',
        		'ds_abreviado' => '3a.Rodada',
        		'pc_premio1' => 0,
        		'pc_premio2' => 0,
        		'pc_premio3' => 0,
        		'id_grupo' => 1,
        ]);
        DB::table('tipos_rankings')->insert([
            'id' => 4,
            'ds_nome' => 'Oitavas de Final',
            'dt_limite' => '2022-12-02',
            'hr_limite' => '21:00',
            'cd_status' => 1,
        		'qt_apostas' => 0,
        		'tp_fase' => 'S',
        		'ds_badge' => '',
        		'id_handicap_casa' => false,
        		'tp_serie' => '',
        		'ds_abreviado' => 'Oitavas',
        		'pc_premio1' => 0,
        		'pc_premio2' => 0,
        		'pc_premio3' => 0,	
        		'id_grupo' => 1,
        ]);
        DB::table('tipos_rankings')->insert([
            'id' => 5,
            'ds_nome' => 'Quartas de Final',
            'dt_limite' => '2022-12-08',
            'hr_limite' => '21:00',
            'cd_status' => 1,
        		'qt_apostas' => 0,
        		'tp_fase' => 'S',
        		'ds_badge' => '',
        		'id_handicap_casa' => false,
        		'tp_serie' => '',
        		'ds_abreviado' => 'Quartas',
        		'pc_premio1' => 0,
        		'pc_premio2' => 0,
        		'pc_premio3' => 0,	
        		'id_grupo' => 1,
        ]);
        DB::table('tipos_rankings')->insert([
            'id' => 6,
            'ds_nome' => 'Semi-Final',
            'dt_limite' => '2022-12-12',
            'hr_limite' => '21:00',
            'cd_status' => 1,
        		'qt_apostas' => 0,
        		'tp_fase' => 'S',
        		'ds_badge' => '',
        		'id_handicap_casa' => false,
        		'tp_serie' => '',
        		'ds_abreviado' => 'Finais',
        		'pc_premio1' => 0,
        		'pc_premio2' => 0,
        		'pc_premio3' => 0,	
        		'id_grupo' => 1,
        ]);
        DB::table('tipos_rankings')->insert([
            'id' => 7,
            'ds_nome' => '3o. Lugar e Final',
            'dt_limite' => '2022-12-16',
            'hr_limite' => '21:00',
            'cd_status' => 1,
        		'qt_apostas' => 0,
        		'tp_fase' => 'S',
        		'ds_badge' => '',
        		'id_handicap_casa' => false,
        		'tp_serie' => '',
        		'ds_abreviado' => 'Finais',
        		'pc_premio1' => 0,
        		'pc_premio2' => 0,
        		'pc_premio3' => 0,	
        		'id_grupo' => 1,
        ]);
        DB::table('tipos_rankings')->insert([
            'id' => 8,
            'ds_nome' => 'Classificação Geral',
            'dt_limite' => '2022-12-17',
            'hr_limite' => '21:00',
            'cd_status' => 1,
        		'qt_apostas' => 0,
        		'tp_fase' => 'G',
        		'ds_badge' => '',
        		'id_handicap_casa' => false,
        		'tp_serie' => '',
        		'ds_abreviado' => 'GERAL',
        		'pc_premio1' => 0,
        		'pc_premio2' => 0,
        		'pc_premio3' => 0,	
        		'id_grupo' => 9,
        ]);
    }
}
