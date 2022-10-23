<?php

namespace Database\Factories;   

use App\Models\PropostaJogador;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropostaJogador>
 */
class PropostaJogadorFactory extends Factory
{
    protected $model = PropostaJogador::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_proposta' => 1,
            'id_jogador' => 1, 
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
