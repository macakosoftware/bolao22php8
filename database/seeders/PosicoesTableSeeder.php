<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PosicoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posicoes')->insert([
            'id' => 1,
            'ds_nome' => 'Goleiro',
            'ds_abreviado' => 'GL',
            'cd_posicao' => 'G'            
        ]);
        DB::table('posicoes')->insert([
            'id' => 2,
            'ds_nome' => 'Zagueiro',
            'ds_abreviado' => 'ZG',
            'cd_posicao' => 'D'            
        ]);
        DB::table('posicoes')->insert([
            'id' => 3,
            'ds_nome' => 'Lateral Direito',
            'ds_abreviado' => 'LD',
            'cd_posicao' => 'D'            
        ]);
        DB::table('posicoes')->insert([
            'id' => 4,
            'ds_nome' => 'Lateral Esquerdo',
            'ds_abreviado' => 'LE',
            'cd_posicao' => 'D'            
        ]);
        DB::table('posicoes')->insert([
            'id' => 5,
            'ds_nome' => 'Médio Defensivo',
            'ds_abreviado' => 'MD',
            'cd_posicao' => 'M'            
        ]);
        DB::table('posicoes')->insert([
            'id' => 6,
            'ds_nome' => 'Meia Central',
            'ds_abreviado' => 'MC',
            'cd_posicao' => 'M'            
        ]);
        DB::table('posicoes')->insert([
            'id' => 7,
            'ds_nome' => 'Ponta Esquerda',
            'ds_abreviado' => 'PE',
            'cd_posicao' => 'A'
        ]);
        DB::table('posicoes')->insert([
            'id' => 8,
            'ds_nome' => 'Ponta Direita',
            'ds_abreviado' => 'PD',
            'cd_posicao' => 'A'            
        ]);
        DB::table('posicoes')->insert([
            'id' => 9,
            'ds_nome' => 'Ponta de Lança',
            'ds_abreviado' => 'PL',
            'cd_posicao' => 'A'            
        ]);
        DB::table('posicoes')->insert([
            'id' => 10,
            'ds_nome' => 'Atacante',
            'ds_abreviado' => 'AT',
            'cd_posicao' => 'A'            
        ]);        
        DB::table('posicoes')->insert([
            'id' => 11,
            'ds_nome' => 'Ala Esquerdo',
            'ds_abreviado' => 'AE',
            'cd_posicao' => 'M'            
        ]);
        DB::table('posicoes')->insert([
            'id' => 12,
            'ds_nome' => 'Ala Direito',
            'ds_abreviado' => 'AD',
            'cd_posicao' => 'M'            
        ]);
    }
}
