<?php

namespace Database\Factories;

use App\Models\TransacaoProposta;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransacaoProposta>
 */
class TransacaoPropostaFactory extends Factory
{
    protected $model = TransacaoProposta::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_transacao' => 1,
            'id_user_proposta' => 1,
            'vl_proposta' => 100,
            'cd_status' => TransacaoProposta::STATUS_ENVIADA,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'ds_observacao' => fake()->text(),
            'ds_resposta' => fake()->text(),
        ];
    }
}
