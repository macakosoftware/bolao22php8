<?php

namespace Database\Factories;

use App\Models\PoolValor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PoolValor>
 */
class PoolValorFactory extends Factory
{

    protected $model = PoolValor::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_pool' => 1,
            'cd_valor' => fake()->randomLetter(),
            'ds_valor' => fake()->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
