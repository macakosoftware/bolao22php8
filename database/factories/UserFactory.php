<?php

namespace Database\Factories;

use App\Models\Pagamento;
use App\Models\Perfil;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{

    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),            
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'cd_perfil' => Perfil::PERFIL_ADMINISTRADOR,
            'cd_pagamento' => Pagamento::PENDENTE_PAGAMENTO,
            'vl_pagamento' => 0,
            'vl_premio' => 0,
        	'qt_pontos_xp' => 0
        ];
    }    
}
