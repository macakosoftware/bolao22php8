<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlacaresPontosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DIFERENCA ZERO
        DB::table('placares_pontos')->insert([
            'cd_placar' => 1,
            'nr_dif_inicial' => 0,
            'nr_dif_final' => 0,
            'qt_pontos1' => 2.69,
            'qt_pontos2' => 2.69
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 2,
            'nr_dif_inicial' => 0,
            'nr_dif_final' => 0,
            'qt_pontos1' => 3.41,
            'qt_pontos2' => 3.41
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 3,
            'nr_dif_inicial' => 0,
            'nr_dif_final' => 0,
            'qt_pontos1' => 4.49,
            'qt_pontos2' => 4.49
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 4,
            'nr_dif_inicial' => 0,
            'nr_dif_final' => 0,
            'qt_pontos1' => 5.03,
            'qt_pontos2' => 5.03
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 5,
            'nr_dif_inicial' => 0,
            'nr_dif_final' => 0,
            'qt_pontos1' => 6.06,
            'qt_pontos2' => 6.06
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 6,
            'nr_dif_inicial' => 0,
            'nr_dif_final' => 0,
            'qt_pontos1' => 6.47,
            'qt_pontos2' => 6.47
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 7,
            'nr_dif_inicial' => 0,
            'nr_dif_final' => 0,
            'qt_pontos1' => 8.68,
            'qt_pontos2' => 8.68
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 8,
            'nr_dif_inicial' => 0,
            'nr_dif_final' => 0,
            'qt_pontos1' => 10.91,
            'qt_pontos2' => 10.91
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 9,
            'nr_dif_inicial' => 0,
            'nr_dif_final' => 0,
            'qt_pontos1' => 13.64,
            'qt_pontos2' => 13.64
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 10,
            'nr_dif_inicial' => 0,
            'nr_dif_final' => 0,
            'qt_pontos1' => 14.69,
            'qt_pontos2' => 14.69
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 11,
            'nr_dif_inicial' => 0,
            'nr_dif_final' => 0,
            'qt_pontos1' => 15,
            'qt_pontos2' => 15
        ]);
        
        // DIFERENCA DE 30
        DB::table('placares_pontos')->insert([
            'cd_placar' => 1,
            'nr_dif_inicial' => 1,
            'nr_dif_final' => 30,
            'qt_pontos1' => 2.42,
            'qt_pontos2' => 2.96
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 2,
            'nr_dif_inicial' => 1,
            'nr_dif_final' => 30,
            'qt_pontos1' => 3.07,
            'qt_pontos2' => 3.75
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 3,
            'nr_dif_inicial' => 1,
            'nr_dif_final' => 30,
            'qt_pontos1' => 4.49,
            'qt_pontos2' => 5.30
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 4,
            'nr_dif_inicial' => 1,
            'nr_dif_final' => 30,
            'qt_pontos1' => 4.52,
            'qt_pontos2' => 5.53
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 5,
            'nr_dif_inicial' => 1,
            'nr_dif_final' => 30,
            'qt_pontos1' => 5.46,
            'qt_pontos2' => 6.67
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 6,
            'nr_dif_inicial' => 1,
            'nr_dif_final' => 30,
            'qt_pontos1' => 5.83,
            'qt_pontos2' => 7.12
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 7,
            'nr_dif_inicial' => 1,
            'nr_dif_final' => 30,
            'qt_pontos1' => 7.81,
            'qt_pontos2' => 9.55
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 8,
            'nr_dif_inicial' => 1,
            'nr_dif_final' => 30,
            'qt_pontos1' => 9.82,
            'qt_pontos2' => 12.01
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 9,
            'nr_dif_inicial' => 1,
            'nr_dif_final' => 30,
            'qt_pontos1' => 12.28,
            'qt_pontos2' => 15
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 10,
            'nr_dif_inicial' => 1,
            'nr_dif_final' => 30,
            'qt_pontos1' => 13.22,
            'qt_pontos2' => 15
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 11,
            'nr_dif_inicial' => 1,
            'nr_dif_final' => 30,
            'qt_pontos1' => 13.50,
            'qt_pontos2' => 15
        ]);
        
                
        // DIFERENCA DE 50
        DB::table('placares_pontos')->insert([
            'cd_placar' => 1,
            'nr_dif_inicial' => 31,
            'nr_dif_final' => 50,
            'qt_pontos1' => 2.15,
            'qt_pontos2' => 3.23
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 2,
            'nr_dif_inicial' => 31,
            'nr_dif_final' => 50,
            'qt_pontos1' => 2.73,
            'qt_pontos2' => 4.09
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 3,
            'nr_dif_inicial' => 31,
            'nr_dif_final' => 50,
            'qt_pontos1' => 3.60,
            'qt_pontos2' => 5.39
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 4,
            'nr_dif_inicial' => 31,
            'nr_dif_final' => 50,
            'qt_pontos1' => 4.02,
            'qt_pontos2' => 6.03
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 5,
            'nr_dif_inicial' => 31,
            'nr_dif_final' => 50,
            'qt_pontos1' => 4.85,
            'qt_pontos2' => 7.28
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 6,
            'nr_dif_inicial' => 31,
            'nr_dif_final' => 50,
            'qt_pontos1' => 5.18,
            'qt_pontos2' => 7.77
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 7,
            'nr_dif_inicial' => 31,
            'nr_dif_final' => 50,
            'qt_pontos1' => 6.95,
            'qt_pontos2' => 10.42
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 8,
            'nr_dif_inicial' => 31,
            'nr_dif_final' => 50,
            'qt_pontos1' => 8.73,
            'qt_pontos2' => 13.10
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 9,
            'nr_dif_inicial' => 31,
            'nr_dif_final' => 50,
            'qt_pontos1' => 10.91,
            'qt_pontos2' => 15
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 10,
            'nr_dif_inicial' => 31,
            'nr_dif_final' => 50,
            'qt_pontos1' => 11.75,
            'qt_pontos2' => 15
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 11,
            'nr_dif_inicial' => 31,
            'nr_dif_final' => 50,
            'qt_pontos1' => 12,
            'qt_pontos2' => 15
        ]);
        
        
        // DIFERENCA DE 75
        DB::table('placares_pontos')->insert([
            'cd_placar' => 1,
            'nr_dif_inicial' => 51,
            'nr_dif_final' => 75,
            'qt_pontos1' => 2.02,
            'qt_pontos2' => 3.36
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 2,
            'nr_dif_inicial' => 51,
            'nr_dif_final' => 75,
            'qt_pontos1' => 2.56,
            'qt_pontos2' => 4.26
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 3,
            'nr_dif_inicial' => 51,
            'nr_dif_final' => 75,
            'qt_pontos1' => 3.37,
            'qt_pontos2' => 5.62
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 4,
            'nr_dif_inicial' => 51,
            'nr_dif_final' => 75,
            'qt_pontos1' => 3.77,
            'qt_pontos2' => 6.28
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 5,
            'nr_dif_inicial' => 51,
            'nr_dif_final' => 75,
            'qt_pontos1' => 4.55,
            'qt_pontos2' => 7.58
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 6,
            'nr_dif_inicial' => 51,
            'nr_dif_final' => 75,
            'qt_pontos1' => 4.86,
            'qt_pontos2' => 8.09
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 7,
            'nr_dif_inicial' => 51,
            'nr_dif_final' => 75,
            'qt_pontos1' => 6.51,
            'qt_pontos2' => 10.85
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 8,
            'nr_dif_inicial' => 51,
            'nr_dif_final' => 75,
            'qt_pontos1' => 8.19,
            'qt_pontos2' => 13.64
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 9,
            'nr_dif_inicial' => 51,
            'nr_dif_final' => 75,
            'qt_pontos1' => 10.23,
            'qt_pontos2' => 15
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 10,
            'nr_dif_inicial' => 51,
            'nr_dif_final' => 75,
            'qt_pontos1' => 11.02,
            'qt_pontos2' => 15
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 11,
            'nr_dif_inicial' => 51,
            'nr_dif_final' => 75,
            'qt_pontos1' => 11.25,
            'qt_pontos2' => 15
        ]);
        
        
        // MAIS DE 75 de diferenca        
        DB::table('placares_pontos')->insert([
            'cd_placar' => 1,
            'nr_dif_inicial' => 76,
            'nr_dif_final' => 100,
            'qt_pontos1' => 1.88,
            'qt_pontos2' => 3.50
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 2,
            'nr_dif_inicial' => 76,
            'nr_dif_final' => 100,
            'qt_pontos1' => 2.39,
            'qt_pontos2' => 4.43
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 3,
            'nr_dif_inicial' => 76,
            'nr_dif_final' => 100,
            'qt_pontos1' => 3.15,
            'qt_pontos2' => 5.84
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 4,
            'nr_dif_inicial' => 76,
            'nr_dif_final' => 100,
            'qt_pontos1' => 3.52,
            'qt_pontos2' => 6.53
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 5,
            'nr_dif_inicial' => 76,
            'nr_dif_final' => 100,
            'qt_pontos1' => 4.24,
            'qt_pontos2' => 7.88
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 6,
            'nr_dif_inicial' => 76,
            'nr_dif_final' => 100,
            'qt_pontos1' => 4.53,
            'qt_pontos2' => 8.42
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 7,
            'nr_dif_inicial' => 76,
            'nr_dif_final' => 100,
            'qt_pontos1' => 6.08,
            'qt_pontos2' => 11.29
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 8,
            'nr_dif_inicial' => 76,
            'nr_dif_final' => 100,
            'qt_pontos1' => 7.64,
            'qt_pontos2' => 14.19
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 9,
            'nr_dif_inicial' => 76,
            'nr_dif_final' => 100,
            'qt_pontos1' => 9.55,
            'qt_pontos2' => 15
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 10,
            'nr_dif_inicial' => 76,
            'nr_dif_final' => 100,
            'qt_pontos1' => 10.28,
            'qt_pontos2' => 15
        ]);
        DB::table('placares_pontos')->insert([
            'cd_placar' => 11,
            'nr_dif_inicial' => 76,
            'nr_dif_final' => 100,
            'qt_pontos1' => 10.50,
            'qt_pontos2' => 15
        ]);
    }
}
