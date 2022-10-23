<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusRankingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_rankings')->insert([
            'id' => 1,
            'ds_status' => 'Aberto'
        ]);        
        DB::table('status_rankings')->insert([
            'id' => 2,
            'ds_status' => 'Fechado'
        ]);        
    }
}
