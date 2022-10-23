<?php

namespace Database\Factories;

use App\Models\JogadorUsuario;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JogadorUsuario>
 */
class JogadorUsuarioFactory extends Factory
{
    protected $model = JogadorUsuario::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_jogador' => 1,
            'id_user' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
