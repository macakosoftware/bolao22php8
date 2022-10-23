<?php

namespace Database\Factories;

use App\Models\Jogador;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jogador>
 */
class JogadorFactory extends Factory
{

    protected $model = Jogador::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_selecao' => rand(1,32),
            'ds_selecao' => fake()->name(),
            'ds_numero' => '', 
            'ds_nome' => fake()->name(),
            'ds_abreviado' => fake()->name(),
            'ds_posicao' => fake()->shuffle('GL','LD', 'LE', 'AT'),
            'dt_nascimento' => '1901-01-01',
            'ds_time' => fake()->name(),
            'ds_valor' => '',
            'created_at' => now(),
            'updated_at' => now(),
            'id_posicao' => rand(1,12),
            'vl_preco' => 1000,
            'nr_ini_random' => 1,
            'nr_fim_random' => 1,
            'tp_jogador' => '',
            'nr_camisa' => rand(1,10)
        ];
    }
   
}
