<?php

namespace Database\Factories;

use App\Models\Jogo;
use App\Models\StatusJogo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jogo>
 */
class JogoFactory extends Factory
{

    protected $model = Jogo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $id_selecao1 = rand(1,32);
        $id_selecao2 = $id_selecao1;
        while($id_selecao1 == $id_selecao2){
            $id_selecao2 = rand(1,32);
        }
        return [
            'id_selecao1' => $id_selecao1,
            'id_selecao2' => $id_selecao2,
            'dt_jogo' => '2022-11-20',
            'hr_jogo' => '13:00:00', 
            'id_estadio' => rand(1,8),
            'cd_status' => StatusJogo::JOGO_PROGRAMADO,
            'created_at' => now(),
            'updated_at' => now(),
            'cd_ranking' => 1,
            'qt_gols_selecao1' => 0,
            'qt_gols_selecao2' => 0,
            'ds_selecao1' => '',
            'ds_selecao2' => '',
            'id_vencedor' => 0,
            'qt_gols_penal_selecao1' => 0,
            'qt_gols_penal_selecao2' => 0,
            'nr_pontos_handcap1' => 0,
            'nr_pontos_handcapX' => 0,
            'nr_pontos_handcap2' => 0,
            'id_penal' => false,
        ];       
    }
}
