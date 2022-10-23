<?php 
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JogadoresTableSeeder extends Seeder
{
   /**
   * Run the database seeds.
   *
   * @return void
   */
   public function run()
   {
       DB::table('jogadores')->insert([
       ]);
       DB::table('jogadores')->insert([
           'id' => '1', 
           'id_selecao' => '1', 
           'ds_selecao' => 'Qatar', 
           'ds_numero' => '1', 
           'ds_nome' => 'Saad Al-Sheeb', 
           'ds_abreviado' => 'Al-Sheeb', 
           'ds_posicao' => 'Goleiro', 
           'dt_nascimento' => '1901-01-01', 
           'ds_time' => 'Qatar', 
           'ds_valor' => '1', 
           'created_at' => Carbon::now(), 
           'updated_at' => Carbon::now(), 
           'id_posicao' => '1', 
           'vl_preco' => '0', 
           'nr_ini_random' => '1', 
           'nr_fim_random' => '100', 
           'tp_jogador' => 'N', 
           'nr_camisa' => '1', 
       ]);
       DB::table('jogadores')->insert([
           'id' => '2', 
           'id_selecao' => '2', 
           'ds_selecao' => 'Equador', 
           'ds_numero' => '1', 
           'ds_nome' => 'Hernan Galindez', 
           'ds_abreviado' => 'Galindez', 
           'ds_posicao' => 'Goleiro', 
           'dt_nascimento' => '1901-01-01', 
           'ds_time' => 'Equador', 
           'ds_valor' => '1', 
           'created_at' => Carbon::now(), 
           'updated_at' => Carbon::now(), 
           'id_posicao' => '1', 
           'vl_preco' => '0', 
           'nr_ini_random' => '101', 
           'nr_fim_random' => '200', 
           'tp_jogador' => 'N', 
           'nr_camisa' => '1', 
       ]);
       DB::table('jogadores')->insert([
           'id' => '3', 
           'id_selecao' => '3', 
           'ds_selecao' => 'Senegal', 
           'ds_numero' => '1', 
           'ds_nome' => 'Seny Dieng', 
           'ds_abreviado' => 'Dieng', 
           'ds_posicao' => 'Goleiro', 
           'dt_nascimento' => '1901-01-01', 
           'ds_time' => 'Senegal', 
           'ds_valor' => '1', 
           'created_at' => Carbon::now(), 
           'updated_at' => Carbon::now(), 
           'id_posicao' => '1', 
           'vl_preco' => '0', 
           'nr_ini_random' => '201', 
           'nr_fim_random' => '300', 
           'tp_jogador' => 'N', 
           'nr_camisa' => '1', 
       ]);
       DB::table('jogadores')->insert([
           'id' => '4', 
           'id_selecao' => '4', 
           'ds_selecao' => 'Holanda', 
           'ds_numero' => '4', 
           'ds_nome' => 'Virgil van Djik', 
           'ds_abreviado' => 'Van Djik', 
           'ds_posicao' => 'Zagueiro', 
           'dt_nascimento' => '1901-01-01', 
           'ds_time' => 'Holanda', 
           'ds_valor' => '1', 
           'created_at' => Carbon::now(), 
           'updated_at' => Carbon::now(), 
           'id_posicao' => '2', 
           'vl_preco' => '0', 
           'nr_ini_random' => '301', 
           'nr_fim_random' => '400', 
           'tp_jogador' => 'G', 
           'nr_camisa' => '4', 
       ]);
   }
}
