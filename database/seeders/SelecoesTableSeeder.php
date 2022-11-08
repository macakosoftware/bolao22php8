<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SelecoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('selecoes')->insert([
            'id' => 1,
            'ds_nome' => 'Qatar',
            'ds_icone' => 'qatar.png',
            'id_grupo' => 1,
            'cd_handcap' => 9,
        	'ds_cor' => 'vermelha',
        	'ds_fonte' => '',
        	'ds_cor2' => '#ffffff'
        ]);
        DB::table('selecoes')->insert([
            'id' => 2,
            'ds_nome' => 'Equador',
            'ds_icone' => 'equador.png',
            'id_grupo' => 1,
            'cd_handcap' => 8,
        		'ds_cor' => 'amarela',
        		'ds_fonte' => '',
        		'ds_cor2' => '#0000ff'
        ]);
        DB::table('selecoes')->insert([
            'id' => 3,
            'ds_nome' => 'Senegal',
            'ds_icone' => 'senegal.png',
            'id_grupo' => 1,
            'cd_handcap' => 6,
        		'ds_cor' => 'verde',
        		'ds_fonte' => '',
        		'ds_cor2' => '#ffff00'
        ]);
        DB::table('selecoes')->insert([
            'id' => 4,
            'ds_nome' => 'Holanda',
            'ds_icone' => 'holanda.png',
            'id_grupo' => 1,
            'cd_handcap' => 4,
        		'ds_cor' => 'laranja',
        		'ds_fonte' => '',
        		'ds_cor2' => '#ffffff'
        ]);
        DB::table('selecoes')->insert([
            'id' => 5,
            'ds_nome' => 'Inglaterra',
            'ds_icone' => 'inglaterra.png',
            'id_grupo' => 2,
            'cd_handcap' => 2,
        		'ds_cor' => 'branca',
        		'ds_fonte' => '',
        		'ds_cor2' => '#0000FF'
        ]);
        DB::table('selecoes')->insert([
            'id' => 6,
            'ds_nome' => 'Irã',
            'ds_icone' => 'ira.png',
            'id_grupo' => 2,
            'cd_handcap' => 10,
        		'ds_cor' => 'branca',
        		'ds_fonte' => '',
        		'ds_cor2' => '#FF0000'
        ]);
        DB::table('selecoes')->insert([
            'id' => 7,
            'ds_nome' => 'Estados Unidos',
            'ds_icone' => 'eua.png',
            'id_grupo' => 2,
            'cd_handcap' => 6,
        		'ds_cor' => 'branca',
        		'ds_fonte' => '',
        		'ds_cor2' => '#0000CD'
        ]);
        DB::table('selecoes')->insert([
            'id' => 8,
            'ds_nome' => 'País de Gales',
            'ds_icone' => 'gales.png',
            'id_grupo' => 2,
            'cd_handcap' => 8,
        		'ds_cor' => 'vermelha',
        		'ds_fonte' => '',
        		'ds_cor2' => '#ffffff'
        ]);
        DB::table('selecoes')->insert([
            'id' => 9,
            'ds_nome' => 'Argentina',
            'ds_icone' => 'argentina.png',
            'id_grupo' => 3,
            'cd_handcap' => 3,
        		'ds_cor' => 'argentina',
        		'ds_fonte' => '',
        		'ds_cor2' => '#000000'
        ]);
        DB::table('selecoes')->insert([
            'id' => 10,
            'ds_nome' => 'Arábia Saudita',
            'ds_icone' => 'arabia_saudita.png',
            'id_grupo' => 3,
            'cd_handcap' => 10,
        		'ds_cor' => 'verde',
        		'ds_fonte' => '',
        		'ds_cor2' => '#ffffff'
        ]);
        DB::table('selecoes')->insert([
            'id' => 11,
            'ds_nome' => 'México',
            'ds_icone' => 'mexico.png',
            'id_grupo' => 3,
            'cd_handcap' => 7,
        		'ds_cor' => 'verde',
        		'ds_fonte' => '',
        		'ds_cor2' => '#ffffff'
        ]);
        DB::table('selecoes')->insert([
            'id' => 12,
            'ds_nome' => 'Polônia',
            'ds_icone' => 'polonia.png',
            'id_grupo' => 3,
            'cd_handcap' => 6,
        		'ds_cor' => 'vermelha',
        		'ds_fonte' => '',
        		'ds_cor2' => '#ffffff'
        ]);
        DB::table('selecoes')->insert([
            'id' => 13,
            'ds_nome' => 'França',
            'ds_icone' => 'franca.png',
            'id_grupo' => 4,
            'cd_handcap' => 1,
        		'ds_cor' => 'japao',
        		'ds_fonte' => '',
        		'ds_cor2' => '#ffffff'
        ]);
        DB::table('selecoes')->insert([
            'id' => 14,
            'ds_nome' => 'Austrália',
            'ds_icone' => 'australia.png',
            'id_grupo' => 4,
            'cd_handcap' => 10,
        		'ds_cor' => 'australia',
        		'ds_fonte' => '',
        		'ds_cor2' => '#228B22'
        ]);
        DB::table('selecoes')->insert([
            'id' => 15,
            'ds_nome' => 'Dinamarca',
            'ds_icone' => 'dinamarca.png',
            'id_grupo' => 4,
            'cd_handcap' => 5,
        		'ds_cor' => 'vermelha',
        		'ds_fonte' => '',
        		'ds_cor2' => '#ffffff'
        ]);
        DB::table('selecoes')->insert([
            'id' => 16,
            'ds_nome' => 'Tunísia',
            'ds_icone' => 'tunisia.png',
            'id_grupo' => 4,
            'cd_handcap' => 9,
        		'ds_cor' => 'vermelha',
        		'ds_fonte' => '',
        		'ds_cor2' => '#ffffff'
        ]);
        DB::table('selecoes')->insert([
            'id' => 17,
            'ds_nome' => 'Espanha',
            'ds_icone' => 'espanha.png',
            'id_grupo' => 5,
            'cd_handcap' => 2,
        		'ds_cor' => 'vermelha',
        		'ds_fonte' => '',
        		'ds_cor2' => '#FFBF00'
        ]);
        DB::table('selecoes')->insert([
            'id' => 18,
            'ds_nome' => 'Costa Rica',
            'ds_icone' => 'costa_rica.png',
            'id_grupo' => 5,
            'cd_handcap' => 10,
        		'ds_cor' => 'vermelha',
        		'ds_fonte' => '',
        		'ds_cor2' => '#ffffff'
        ]);
        DB::table('selecoes')->insert([
            'id' => 19,
            'ds_nome' => 'Alemanha',
            'ds_icone' => 'alemanha.png',
            'id_grupo' => 5,
            'cd_handcap' => 3,
        		'ds_cor' => 'branca',
        		'ds_fonte' => '',
        		'ds_cor2' => '#000000'
        ]);
        DB::table('selecoes')->insert([
            'id' => 20,
            'ds_nome' => 'Japão',
            'ds_icone' => 'japao.png',
            'id_grupo' => 5,
            'cd_handcap' => 9,
        		'ds_cor' => 'japao',
        		'ds_fonte' => '',
        		'ds_cor2' => '#ffffff'
        ]);
        DB::table('selecoes')->insert([
            'id' => 21,
            'ds_nome' => 'Bélgica',
            'ds_icone' => 'belgica.png',
            'id_grupo' => 6,
            'cd_handcap' => 3,
        		'ds_cor' => 'vermelha',
        		'ds_fonte' => '',
        		'ds_cor2' => '#FFEA00'
        ]);
        DB::table('selecoes')->insert([
            'id' => 22,
            'ds_nome' => 'Canadá',
            'ds_icone' => 'canada.png',
            'id_grupo' => 6,
            'cd_handcap' => 9,
        		'ds_cor' => 'vermelha',
        		'ds_fonte' => '',
        		'ds_cor2' => '#ffffff'
        ]);
        DB::table('selecoes')->insert([
            'id' => 23,
            'ds_nome' => 'Marrocos',
            'ds_icone' => 'marrocos.png',
            'id_grupo' => 6,
            'cd_handcap' => 8,
        		'ds_cor' => 'vermelha',
        		'ds_fonte' => '',
        		'ds_cor2' => '#008000'
        ]);
        DB::table('selecoes')->insert([
            'id' => 24,
            'ds_nome' => 'Croácia',
            'ds_icone' => 'croacia.png',
            'id_grupo' => 6,
            'cd_handcap' => 5,
        		'ds_cor' => 'croacia',
        		'ds_fonte' => '',
        		'ds_cor2' => '#0000FF'
        ]);
        DB::table('selecoes')->insert([
            'id' => 25,
            'ds_nome' => 'Brasil',
            'ds_icone' => 'brasil.png',
            'id_grupo' => 7,
            'cd_handcap' => 1,
        		'ds_cor' => 'amarela',
        		'ds_fonte' => '',
        		'ds_cor2' => '#008000'
        ]);
        DB::table('selecoes')->insert([
            'id' => 26,
            'ds_nome' => 'Sérvia',
            'ds_icone' => 'servia.png',
            'id_grupo' => 7,
            'cd_handcap' => 7,
        		'ds_cor' => 'branca',
        		'ds_fonte' => '',
        		'ds_cor2' => '#FF0000'
        ]);
        DB::table('selecoes')->insert([
            'id' => 27,
            'ds_nome' => 'Suiça',
            'ds_icone' => 'suica.png',
            'id_grupo' => 7,
            'cd_handcap' => 7,
        		'ds_cor' => 'vermelha',
        		'ds_fonte' => '',
        		'ds_cor2' => '#ffffff'
        ]);
        DB::table('selecoes')->insert([
            'id' => 28,
            'ds_nome' => 'Camarões',
            'ds_icone' => 'camaroes.png',
            'id_grupo' => 7,
            'cd_handcap' => 8,
        		'ds_cor' => 'verde',
        		'ds_fonte' => '',
        		'ds_cor2' => '#FFFF00'
        ]);
        DB::table('selecoes')->insert([
            'id' => 29,
            'ds_nome' => 'Portugal',
            'ds_icone' => 'portugal.png',
            'id_grupo' => 8,
            'cd_handcap' => 4,
        		'ds_cor' => 'vermelha',
        		'ds_fonte' => '',
        		'ds_cor2' => '#8B8000'
        ]);
        DB::table('selecoes')->insert([
            'id' => 30,
            'ds_nome' => 'Gana',
            'ds_icone' => 'gana.png',
            'id_grupo' => 8,
            'cd_handcap' => 8,
        		'ds_cor' => 'branca',
        		'ds_fonte' => '',
        		'ds_cor2' => '#000000'
        ]);
        DB::table('selecoes')->insert([
            'id' => 31,
            'ds_nome' => 'Uruguai',
            'ds_icone' => 'uruguai.png',
            'id_grupo' => 8,
            'cd_handcap' => 5,
        		'ds_cor' => 'azul',
        		'ds_fonte' => '',
        		'ds_cor2' => '#ffffff'
        ]);
        DB::table('selecoes')->insert([
            'id' => 32,
            'ds_nome' => 'Coréia do Sul',
            'ds_icone' => 'coreia_do_sul.png',
            'id_grupo' => 8,
            'cd_handcap' => 10,
        		'ds_cor' => 'vermelha',
        		'ds_fonte' => '',
        		'ds_cor2' => '#000000'
        ]);
        DB::table('selecoes')->insert([
            'id' => 33,
            'ds_nome' => 'TBD',
            'ds_icone' => 'fifa.jpeg',
            'id_grupo' => 8,
            'cd_handcap' => 10,
        		'ds_cor' => '',
        		'ds_fonte' => '',
        		'ds_cor2' => ''
        ]);
    }
}
