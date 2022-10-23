<?php

namespace Tests\Feature;

use App\Models\Jogador;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\PagamentosTableSeeder;
use Database\Seeders\PerfisTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConsoleTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PerfisTableSeeder::class);
        $this->seed(PagamentosTableSeeder::class);
        $this->user = User::factory()->create();
    }

    public function test_figurinhas_apaga_notificacoes_vazio(){
        $this->artisan('figurinhas:apagarNotificacao')->assertSuccessful();
    }

    public function test_figurinhas_apaga_notificacoes_com_conteudo(){
        //$jogador = Jogador::factory()->make();
        //$jogador->save();
        
        $this->artisan('figurinhas:apagarNotificacao')->assertSuccessful();
    }

    public function test_pontosxp_credito_diario(){
        $this->artisan('pontosxp:creditodiario')->assertSuccessful();
    }

    public function test_jogos_trava_jogo(){
        $this->artisan('jogos:travajogo')->assertSuccessful();
    }

    public function test_apostas_lembrete(){
        $this->artisan('apostas:lembrete')->assertSuccessful();
    }

    public function test_apostas_enviar_aviso(){
        $this->artisan('apostas:enviarAviso')->assertSuccessful();
    }

    public function test_figurinhas_apagar_notificacao(){
        $this->artisan('figurinhas:apagarNotificacao')->assertSuccessful();
    }
}