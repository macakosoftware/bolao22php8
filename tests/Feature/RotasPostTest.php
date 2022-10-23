<?php

namespace Tests\Feature;

use App\Models\Jogo;
use App\Models\User;
use Database\Seeders\EstadiosTableSeeder;
use Database\Seeders\GruposTableSeeder;
use Database\Seeders\HandcapsTableSeeder;
use Database\Seeders\PagamentosTableSeeder;
use Database\Seeders\PerfisTableSeeder;
use Database\Seeders\PlacaresPontosTableSeeder;
use Database\Seeders\PlacaresTableSeeder;
use Database\Seeders\SelecoesTableSeeder;
use Database\Seeders\StatusJogosTableSeeder;
use Database\Seeders\StatusRankingsTableSeeder;
use Database\Seeders\TiposRankingsTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class RotasPostTest extends TestCase
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

    public function test_alterar_perfil_sem_senha(){        
        $nome = fake()->name();
        $email = fake()->email();

        $response = $this->actingAs($this->user)
        ->withSession(['banned' => false])
        ->followingRedirects()
        ->post('/alterarPerfil', ['nome' => $nome, 'email' => $email]);

        $response->assertStatus(200);

        $user = User::where('id',$this->user->id)->first();
        assertEquals($nome, $user->name, 'Nome do Usuário depois de alterar o perfil não é igual');
        assertEquals($email, $user->email, 'Email do Usuário depois de alterar o perfil não é igual');
    }

    public function test_alterar_perfil_com_senha(){    
        $senha = 'teste123';
        $encrypted = bcrypt($senha);

        $response = $this->actingAs($this->user)
        ->withSession(['banned' => false])
        ->followingRedirects()
        ->post('/alterarPerfil', ['nome' => $this->user->name, 'email' => $this->user->email, 'id_alterar_senha' => true, 'password' => $senha, 'password_confirmation' => $senha]);

        $response->assertStatus(200);
    }

    public function test_apostas_editar(){
        $this->seed(GruposTableSeeder::class);
        $this->seed(HandcapsTableSeeder::class);     
        $this->seed(PlacaresTableSeeder::class);
        $this->seed(PlacaresPontosTableSeeder::class);
        $this->seed(SelecoesTableSeeder::class);
        $this->seed(StatusRankingsTableSeeder::class);
        $this->seed(StatusJogosTableSeeder::class);
        $this->seed(TiposRankingsTableSeeder::class);
        $this->seed(EstadiosTableSeeder::class);
        $jogo = Jogo::factory()->create();        

        $response = $this->actingAs($this->user)
        ->withSession(['banned' => false])
        ->followingRedirects()
        ->post('/apostas/editar', ['ds_ids' => $jogo->id, 'placar1_'.$jogo->id => 1, 'placar2_'.$jogo->id => 0, 'id_penal_'.$jogo->id => false, 'id_selecao_penal_'.$jogo->id => $jogo->selecao1->id]);

        $response->assertStatus(200);
    }
}