<?php

namespace Database\Factories;

use App\Models\TransacaoFigurinha;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransacaoFigurinha>
 */
class TransacaoFigurinhaFactory extends Factory
{
    protected $model = TransacaoFigurinha::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_user' => 1,
            'id_jogador' => 1,
            'tp_transacao'  => TransacaoFigurinha::TIPO_VENDA,
            'vl_venda' => 100,
            'cd_status' => TransacaoFigurinha::STATUS_ABERTA,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'ds_observacao' => fake()->text(),
        ];
    }
}
