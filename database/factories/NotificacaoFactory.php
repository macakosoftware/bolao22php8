<?php

namespace Database\Factories;

use App\Models\Notificacao;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notificacao>
 */
class NotificacaoFactory extends Factory
{

    protected $model = Notificacao::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ds_icon' => 'factory',
            'ds_cor' => '#000000',
            'ds_texto' => substr(fake()->text(),0,100),
            'ds_numero' => '1',
            'ds_link' => 'factory',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'ds_descricao' => fake()->text(),
            'tp_notificacao' => 1
        ];
    }
}
