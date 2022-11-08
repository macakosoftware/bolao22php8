<?php

use Illuminate\Database\Seeder;
use Database\Seeders\PerfisTableSeeder;
use Database\Seeders\PagamentosTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\EstadiosTableSeeder;
use Database\Seeders\FormaPagamentoSeeder;
use Database\Seeders\GruposTableSeeder;
use Database\Seeders\HandcapsTableSeeder;
use Database\Seeders\SelecoesTableSeeder;
use Database\Seeders\StatusJogosTableSeeder;
use Database\Seeders\StatusRankingsTableSeeder;
use Database\Seeders\TiposRankingsTableSeeder;
use Database\Seeders\PlacaresTableSeeder;
use Database\Seeders\PlacaresPontosTableSeeder;
use Database\Seeders\PosicoesTableSeeder;
use Database\Seeders\JogadoresTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call([
            PerfisTableSeeder::class,
            PagamentosTableSeeder::class,
            UsersTableSeeder::class,
            EstadiosTableSeeder::class,
            GruposTableSeeder::class,
            HandcapsTableSeeder::class,                       
            SelecoesTableSeeder::class,            
            StatusJogosTableSeeder::class,
            StatusRankingsTableSeeder::class,
            TiposRankingsTableSeeder::class,
            PlacaresTableSeeder::class,
            PlacaresPontosTableSeeder::class,
            PosicoesTableSeeder::class,
            FormaPagamentoSeeder::class,
            JogadoresTableSeeder::class,
        ]);
    }
}
