<?php

namespace Database\Factories;

use App\Models\Destinatario;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Destinatario>
 */
class DestinatarioFactory extends Factory
{

    protected $model = Destinatario::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_mensagem' => 1,
            'id_user' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'id_lido' => false,
        ];
    }
}
