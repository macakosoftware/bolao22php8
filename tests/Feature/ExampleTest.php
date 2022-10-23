<?php

namespace Tests\Feature;

use App\Funcoes\AtualizaProposta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_valida_rota_raiz()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }   
}
