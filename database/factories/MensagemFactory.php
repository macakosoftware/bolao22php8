<?php

namespace Database\Factories;

use App\Models\Mensagem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mensagem>
 */
class MensagemFactory extends Factory
{

    protected $model = Mensagem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_user_from' => 1,
            'ds_mensagem' => fake()->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'ds_titulo' => fake()->name(),
            'id_mensagem_relacionada' => 0,
        ];
    }
}
