<?php

namespace Tests\Feature;

use App\Http\Controllers\Mensagens\MensagensController;
use App\Models\Destinatario;
use App\Models\Jogador;
use App\Models\JogadorUsuario;
use App\Models\Jogo;
use App\Models\Mensagem;
use App\Models\Notificacao;
use App\Models\Pagamento;
use App\Models\Perfil;
use App\Models\Pool;
use App\Models\PoolValor;
use App\Models\PropostaJogador;
use App\Models\StatusRanking;
use App\Models\TipoRanking;
use App\Models\TransacaoFigurinha;
use App\Models\TransacaoProposta;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\EstadiosTableSeeder;
use Database\Seeders\GruposTableSeeder;
use Database\Seeders\HandcapsTableSeeder;
use Database\Seeders\PagamentosTableSeeder;
use Database\Seeders\PerfisTableSeeder;
use Database\Seeders\PosicoesTableSeeder;
use Database\Seeders\SelecoesTableSeeder;
use Database\Seeders\StatusJogosTableSeeder;
use Database\Seeders\StatusRankingsTableSeeder;
use Database\Seeders\TiposRankingsTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RotasGetTest extends TestCase
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

    public function test_rota_raiz()
    {
        $response = $this->call('GET', '/'); 
        $this->assertEquals(200, $response->status());
    }

    public function test_rota_home()
    {
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/home');
 
        $response->assertStatus(200);
    }

    public function test_rota_perfil()  
    {
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/perfil');
 
        $response->assertStatus(200); 
    }

    public function test_rota_trofeus()  
    {
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/trofeus');
 
        $response->assertStatus(200); 
    }

    public function test_rota_regulamento()  
    {
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/regulamento');
 
        $response->assertStatus(200); 
    }

    public function test_rota_apostas_tela_editar()  
    {
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/apostas/telaEditar');
 
        $response->assertStatus(200); 
    }

    public function test_rota_apostas_tela_minha_consulta_lista()  
    {
        $this->seed(StatusRankingsTableSeeder::class);
        $this->seed(TiposRankingsTableSeeder::class);        

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/apostas/telaMinhaConsultaLista?cd_ranking=8&cd_status=0');
 
        $response->assertStatus(200); 
    }

    public function test_rota_apostas_tela_consulta_geral_lista()  
    {
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/apostas/telaConsultaGeralLista');
 
        $response->assertStatus(200); 
    }

    public function test_rota_apostas_tela_detalhe_palpite()  
    {
        $this->seed(StatusRankingsTableSeeder::class);
        $this->seed(TiposRankingsTableSeeder::class);        

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/apostas/telaDetalhePalpite?id_usuario='.$this->user->id.'&cd_status=1&cd_ranking=8');
 
        $response->assertStatus(200); 
    }

    public function test_rota_rankings_tela_filtro_consulta()  
    {
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/rankings/telaFiltroConsulta');
 
        $response->assertStatus(200); 
    }

    public function test_rota_rankings_tela_filtro_informe()  
    {
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/rankings/telaFiltroInforme');
 
        $response->assertStatus(200); 
    }

    public function test_rota_rankings_tela_filtro_fechamento()
    {
        $this->seed(StatusRankingsTableSeeder::class);
        $this->seed(TiposRankingsTableSeeder::class); 
        $ranking = TipoRanking::where('id',1)->first();
        $ranking->cd_status = StatusRanking::FECHADO;
        $ranking->save();

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/rankings/telaFiltroFechamento');
 
        $response->assertStatus(200); 
    }

    public function test_rota_rankings_tela_filtro_certificado()
    {
        $this->seed(StatusRankingsTableSeeder::class);
        $this->seed(TiposRankingsTableSeeder::class); 
        $ranking = TipoRanking::where('id',1)->first();
        $ranking->cd_status = StatusRanking::FECHADO;
        $ranking->save();
        
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/rankings/telaFiltroCertificado');
 
        $response->assertStatus(200); 
    }


    public function test_jogos_tela_incluir_sem_selecao(){
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/jogos/telaIncluir');
 
        $response->assertStatus(200); 
    }

    public function test_jogos_tela_incluir_com_selecao(){
        $this->seed(GruposTableSeeder::class);
        $this->seed(HandcapsTableSeeder::class);
        $this->seed(SelecoesTableSeeder::class);
        $this->seed(StatusRankingsTableSeeder::class);
        $this->seed(StatusJogosTableSeeder::class);
        $this->seed(TiposRankingsTableSeeder::class);
        $this->seed(EstadiosTableSeeder::class);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/jogos/telaIncluir');
 
        $response->assertStatus(200); 
    }
    
    public function test_jogos_tela_consultar_lista(){
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/jogos/telaConsultarLista');
 
        $response->assertStatus(200); 
    }

    public function test_jogos_tela_manutencao_lista(){
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/jogos/telaManutencaoLista');
 
        $response->assertStatus(200);
    }

    public function test_jogos_tela_alterar(){
        $this->seed(GruposTableSeeder::class);
        $this->seed(HandcapsTableSeeder::class);
        $this->seed(SelecoesTableSeeder::class);
        $this->seed(StatusRankingsTableSeeder::class);
        $this->seed(StatusJogosTableSeeder::class);
        $this->seed(TiposRankingsTableSeeder::class);
        $this->seed(EstadiosTableSeeder::class);
        $jogo = Jogo::factory()->create();        

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/jogos/telaAlterar?id='.$jogo->id);
 
        $response->assertStatus(200);
    }

    public function test_jogos_tela_excluir(){
        $this->seed(GruposTableSeeder::class);
        $this->seed(HandcapsTableSeeder::class);
        $this->seed(SelecoesTableSeeder::class);
        $this->seed(StatusRankingsTableSeeder::class);
        $this->seed(StatusJogosTableSeeder::class);
        $this->seed(TiposRankingsTableSeeder::class);
        $this->seed(EstadiosTableSeeder::class);
        $jogo = Jogo::factory()->create();

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/jogos/telaExcluir?id='.$jogo->id);
 
        $response->assertStatus(200);
    }

    public function test_jogos_tela_detalhe(){
        $this->seed(GruposTableSeeder::class);
        $this->seed(HandcapsTableSeeder::class);
        $this->seed(SelecoesTableSeeder::class);
        $this->seed(StatusRankingsTableSeeder::class);
        $this->seed(StatusJogosTableSeeder::class);
        $this->seed(TiposRankingsTableSeeder::class);
        $this->seed(EstadiosTableSeeder::class);
        $jogo = Jogo::factory()->create();

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/jogos/telaDetalhe?id='.$jogo->id);
 
        $response->assertStatus(200);
    }

    public function test_jogos_tela_resultados(){
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/jogos/telaResultados');
 
        $response->assertStatus(200);
    }

    public function test_selecoes_tela_manutencao(){
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/selecoes/telaManutencao');
 
        $response->assertStatus(200);
    }

    /*
    public function test_selecoes_tela_consulta_lista(){
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/selecoes/telaConsultaLista');
 
        $response->assertStatus(200);
    }
    */

    public function test_selecoes_tela_editar(){
        $this->seed(GruposTableSeeder::class);
        $this->seed(HandcapsTableSeeder::class);
        $this->seed(SelecoesTableSeeder::class);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/selecoes/telaEditar?id_selecao='.rand(1,32));
 
        $response->assertStatus(200);
    }

    public function test_tipos_rankings_tela_manutencao_lista(){
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/tiposRankings/telaManutencaoLista');
 
        $response->assertStatus(200);
    }

    public function test_tipos_rankings_tela_controle_ranking_vazio(){
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/tiposRankings/telaControleRanking');
 
        $response->assertStatus(200);
    }

    public function test_tipos_rankings_tela_controle_ranking_preenchido(){
        $this->seed(StatusRankingsTableSeeder::class);
        $this->seed(TiposRankingsTableSeeder::class);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/tiposRankings/telaControleRanking');
 
        $response->assertStatus(200);
    }

    public function test_tipos_rankings_tela_editar_tipo(){
        $this->seed(StatusRankingsTableSeeder::class);
        $this->seed(TiposRankingsTableSeeder::class);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/tiposRankings/telaEditarTipo?id_tipo='.rand(1,8));
 
        $response->assertStatus(200);
    }

    public function test_tipos_rankings_tela_incluir(){
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/tiposRankings/telaIncluir');
 
        $response->assertStatus(200);
    }

    public function test_usuarios_tela_incluir(){
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaIncluir');
 
        $response->assertStatus(200);
    }

    public function test_usuarios_tela_manutencao_lista(){
        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADMINISTRADOR]);
        $user2 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADM_CONTEUDO]);
        $user3 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO]);
        
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaManutencaoLista');
 
        $response->assertStatus(200);
    }

    public function test_usuarios_tela_alterar(){
        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADMINISTRADOR]);
        $user2 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADM_CONTEUDO]);
        $user3 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaAlterar?id='.$user1->id);
 
        $response->assertStatus(200);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaAlterar?id='.$user2->id);
 
        $response->assertStatus(200);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaAlterar?id='.$user3->id);
 
        $response->assertStatus(200);
    }

    public function test_usuarios_tela_exclusao(){
        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADMINISTRADOR]);
        $user2 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADM_CONTEUDO]);
        $user3 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaExclusao?id='.$user1->id);
 
        $response->assertStatus(200);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaExclusao?id='.$user2->id);
 
        $response->assertStatus(200);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaExclusao?id='.$user3->id);
 
        $response->assertStatus(200);
    }

    public function test_usuarios_tela_consultar_lista(){
        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADMINISTRADOR]);
        $user2 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADM_CONTEUDO]);
        $user3 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/consultarLista');
 
        $response->assertStatus(200);
    }

    public function test_usuarios_tela_pagamento_selecao(){
        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADMINISTRADOR]);
        $user2 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADM_CONTEUDO]);
        $user3 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaPagamentoSelecao');
 
        $response->assertStatus(200);
    }

    public function test_usuarios_tela_pagamento_detalhe(){
        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADMINISTRADOR]);
        $user2 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADM_CONTEUDO]);
        $user3 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaPagamentoDetalhe?id_user_selecao='.$user1->id);
 
        $response->assertStatus(200);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaPagamentoDetalhe?id_user_selecao='.$user2->id);
 
        $response->assertStatus(200);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaPagamentoDetalhe?id_user_selecao='.$user3->id);
 
        $response->assertStatus(200);
    }

    public function test_usuarios_tela_recibo_selecao(){
        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADMINISTRADOR, 'cd_pagamento' => Pagamento::PAGO]);
        $user2 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADM_CONTEUDO, 'cd_pagamento' => Pagamento::PAGO]);
        $user3 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO, 'cd_pagamento' => Pagamento::PAGO]);


        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaReciboSelecao?id='.$user1->id);
 
        $response->assertStatus(200);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaReciboSelecao?id='.$user2->id);
 
        $response->assertStatus(200);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaReciboSelecao?id='.$user3->id);
 
        $response->assertStatus(200);
    }

    public function test_usuarios_tela_criar_notificacao(){
        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADMINISTRADOR, 'cd_pagamento' => Pagamento::PAGO]);
        $user2 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADM_CONTEUDO, 'cd_pagamento' => Pagamento::PAGO]);
        $user3 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO, 'cd_pagamento' => Pagamento::PAGO]);


        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaCriarNotificacao');
 
        $response->assertStatus(200);        
    }

    public function test_usuarios_tela_creditar_pontos_xp(){
        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADMINISTRADOR, 'cd_pagamento' => Pagamento::PAGO]);
        $user2 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADM_CONTEUDO, 'cd_pagamento' => Pagamento::PAGO]);
        $user3 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO, 'cd_pagamento' => Pagamento::PAGO]);


        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaCreditarPontosXP');
 
        $response->assertStatus(200);        
    }

    public function test_usuarios_tela_mural(){
        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADMINISTRADOR, 'cd_pagamento' => Pagamento::PAGO]);
        $user2 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADM_CONTEUDO, 'cd_pagamento' => Pagamento::PAGO]);
        $user3 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO, 'cd_pagamento' => Pagamento::PAGO]);


        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaMural');
 
        $response->assertStatus(200);        
    }

    public function test_usuarios_tela_filtro_premio_vazio(){
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaFiltroPremio');
 
        $response->assertStatus(302);        
    }

    public function test_usuarios_tela_filtro_premio_com_ranking(){
        $this->seed(StatusRankingsTableSeeder::class);        
        $this->seed(TiposRankingsTableSeeder::class);

        $ranking = TipoRanking::where('id',1)->first();
        $ranking->cd_status = StatusRanking::FECHADO;
        $ranking->pc_premio1 = 10;
        $ranking->save();

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaFiltroPremio');
 
        $response->assertStatus(200);        
    }

    /*
    public function test_usuarios_tela_selecionar_ganhador(){
        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADMINISTRADOR, 'cd_pagamento' => Pagamento::PAGO]);
        $user2 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADM_CONTEUDO, 'cd_pagamento' => Pagamento::PAGO]);
        $user3 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO, 'cd_pagamento' => Pagamento::PAGO]);


        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaSelecionarGanhador');
 
        $response->assertStatus(200);        
    }

    public function test_usuarios_tela_premio_detalhe(){
        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADMINISTRADOR, 'cd_pagamento' => Pagamento::PAGO]);
        $user2 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADM_CONTEUDO, 'cd_pagamento' => Pagamento::PAGO]);
        $user3 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO, 'cd_pagamento' => Pagamento::PAGO]);


        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaPremioDetalhe');
 
        $response->assertStatus(200);        
    }
    */

    public function test_usuarios_tela_criar_votacao(){
        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADMINISTRADOR, 'cd_pagamento' => Pagamento::PAGO]);
        $user2 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_ADM_CONTEUDO, 'cd_pagamento' => Pagamento::PAGO]);
        $user3 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO, 'cd_pagamento' => Pagamento::PAGO]);


        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaCriarVotacao');
 
        $response->assertStatus(200);        
    }

    public function test_usuarios_tela_lista_votacoes_vazio(){        
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaListaVotacoes');
 
        $response->assertStatus(302);        
    }

    public function test_usuarios_tela_lista_votacoes_com_votacoes(){        
        $pool1 = Pool::factory()->create();
        $poolValores1 = PoolValor::factory()->count(4)->create(['id_pool' => $pool1->id]);

        $pool2 = Pool::factory()->create();
        $poolValores2 = PoolValor::factory()->count(4)->create(['id_pool' => $pool2->id]);

        $pool3 = Pool::factory()->create();
        $poolValores3 = PoolValor::factory()->count(4)->create(['id_pool' => $pool3->id]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/telaListaVotacoes');
 
        $response->assertStatus(200);        
    }

    public function test_usuarios_tela_detalhar_votacao(){
        $pool = Pool::factory()->create();
        $poolValores = PoolValor::factory()->count(4)->create(['id_pool' => $pool->id]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/usuarios/detalharVotacao?id_votacao='.$pool->id);
 
        $response->assertStatus(200);        
    }

    public function test_votacoes_tela_lista_votacoes_vazio(){
        
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/votacoes/telaListaVotacoes');
 
        $response->assertStatus(302);        
    }

    public function test_votacoes_tela_lista_votacoes_com_votacao(){
        $pool = Pool::factory()->create();
        $poolValores = PoolValor::factory()->count(4)->create(['id_pool' => $pool->id]);
        
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/votacoes/telaListaVotacoes');
 
        $response->assertStatus(200);        
    }

    public function test_votacoes_tela_detalhar_votacao(){
        $pool = Pool::factory()->create();
        $poolValores = PoolValor::factory()->count(4)->create(['id_pool' => $pool->id]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/votacoes/detalharVotacao?id_votacao='.$pool->id);
 
        $response->assertStatus(200);        
    }

    public function test_notificacoes_consultar_lista_notificacoes_vazio(){
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/notificacoes/consultarListaNotificacoes');
 
        $response->assertStatus(302);        
    }

    public function test_notificacoes_consultar_lista_notificacoes_com_notificacao(){
        $notificacao = Notificacao::factory()->count(3)->create();

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/notificacoes/consultarListaNotificacoes');
 
        $response->assertStatus(302);        
    }

    public function test_notificacoes_tela_consulta_notificacao_simples(){
        $notificacao = Notificacao::factory()->create();

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/notificacoes/telaConsultaNotSimples?id_notificacao='.$notificacao->id);
 
        $response->assertStatus(200);        
    }

    public function test_jogadores_tela_importar(){
        
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/jogadores/telaImportar');
 
        $response->assertStatus(200);        
    }

    public function test_mensagens_tela_nova_mensagem(){
        
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/mensagens/telaNovaMensagem');
 
        $response->assertStatus(200);        
    }

    public function test_mensagens_tela_ver_mensagem(){
        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO, 'cd_pagamento' => Pagamento::PAGO]);
        $mensagem = Mensagem::factory()->create(['id_user_from' => $user1->id]);
        $destinario = Destinatario::factory()->create(['id_mensagem' => $mensagem->id, 'id_user' => $this->user->id]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/mensagens/telaVerMensagem?id_mensagem='.$mensagem->id);
 
        $response->assertStatus(200);        
    }

    public function test_mensagens_tratar_mensagem(){
        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO, 'cd_pagamento' => Pagamento::PAGO]);
        $mensagem = Mensagem::factory()->create(['id_user_from' => $user1->id]);
        $destinario = Destinatario::factory()->create(['id_mensagem' => $mensagem->id, 'id_user' => $this->user->id]);
        
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/mensagens/tratarMensagem?id_mensagem='.$mensagem->id.'&submit='.MensagensController::BOTAO_RESPONDER);
 
        $response->assertStatus(200);        

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->followingRedirects()
                         ->get('/mensagens/tratarMensagem?id_mensagem='.$mensagem->id.'&submit='.MensagensController::BOTAO_APAGAR);
 
        $response->assertStatus(200);        
    }

    public function test_mensagens_tela_consulta_mensagens_sem_mensagem(){
        
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/mensagens/telaConsultarMensagens');
 
        $response->assertStatus(302);        
    }

    public function test_mensagens_tela_consulta_mensagens_com_mensagem(){
        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO, 'cd_pagamento' => Pagamento::PAGO]);
        $mensagem = Mensagem::factory()->create(['id_user_from' => $user1->id]);
        $destinario = Destinatario::factory()->create(['id_mensagem' => $mensagem->id, 'id_user' => $this->user->id]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/mensagens/telaConsultarMensagens');
 
        $response->assertStatus(200);        
    }

    public function test_figurinhas_tela_comprar(){        
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/telaCompra');
 
        $response->assertStatus(200);        
    }

    public function test_figurinhas_mostrar(){        
        $this->seed(PosicoesTableSeeder::class);
        $this->seed(GruposTableSeeder::class);
        $this->seed(HandcapsTableSeeder::class);
        $this->seed(SelecoesTableSeeder::class);

        $jogador = Jogador::factory()->create();
        JogadorUsuario::factory()->create(['id_jogador' => $jogador->id, 'id_user' => $this->user->id]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/mostrar?id_jogador='.$jogador->id);
 
        $response->assertStatus(200);        
    }

    public function test_figurinhas_tela_linhar_minhas_vazia(){        
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/telaListarMinhas');
 
        $response->assertStatus(302);        
    }

    public function test_figurinhas_tela_linhar_minhas_com_figurinha(){        
        $this->seed(PosicoesTableSeeder::class);
        $this->seed(GruposTableSeeder::class);
        $this->seed(HandcapsTableSeeder::class);
        $this->seed(SelecoesTableSeeder::class);

        $jogador = Jogador::factory()->create();
        JogadorUsuario::factory()->create(['id_jogador' => $jogador->id, 'id_user' => $this->user->id]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/telaListarMinhas');
 
        $response->assertStatus(200);        
    }

    public function test_figurinhas_ver_album_vazio(){        
        $this->seed(GruposTableSeeder::class);
        $this->seed(HandcapsTableSeeder::class);
        $this->seed(SelecoesTableSeeder::class);
        
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/verAlbum');
 
        $response->assertStatus(200);        
    }

    public function test_figurinhas_ver_album_com_figurinha(){        
        $this->seed(PosicoesTableSeeder::class);
        $this->seed(GruposTableSeeder::class);
        $this->seed(HandcapsTableSeeder::class);
        $this->seed(SelecoesTableSeeder::class);

        $jogador = Jogador::factory()->create(['id_selecao' => 1]);
        $jogadorUsuario = JogadorUsuario::factory()->create(['id_jogador' => $jogador->id, 'id_user' => $this->user->id]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/verAlbum');
 
        $response->assertStatus(200);        
    }

    public function test_figurinhas_tela_resumo_vazia(){        
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/telaResumo');
 
        $response->assertStatus(302);        
    }

    public function test_figurinhas_tela_resumo_com_conteudo(){   
        $this->seed(PosicoesTableSeeder::class);
        $this->seed(GruposTableSeeder::class);
        $this->seed(HandcapsTableSeeder::class);
        $this->seed(SelecoesTableSeeder::class);

        $jogador = Jogador::factory()->create();
        JogadorUsuario::factory()->create(['id_jogador' => $jogador->id, 'id_user' => $this->user->id]);
        
        $jogador = Jogador::factory()->create();
        JogadorUsuario::factory()->create(['id_jogador' => $jogador->id, 'id_user' => $this->user->id]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/telaResumo');
 
        $response->assertStatus(200);        
    }

    public function test_figurinhas_tela_trocar(){
        $this->seed(PosicoesTableSeeder::class);
        $this->seed(GruposTableSeeder::class);
        $this->seed(HandcapsTableSeeder::class);
        $this->seed(SelecoesTableSeeder::class);

        $jogador = Jogador::factory()->create();
        $jogadorUsuario = JogadorUsuario::factory()->create(['id_jogador' => $jogador->id, 'id_user' => $this->user->id]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/telaTrocar?id_jogador='.$jogador->id);
 
        $response->assertStatus(200);        
    }

    public function test_figurinhas_tela_vender(){
        $this->seed(PosicoesTableSeeder::class);
        $this->seed(GruposTableSeeder::class);
        $this->seed(HandcapsTableSeeder::class);
        $this->seed(SelecoesTableSeeder::class);

        $jogador = Jogador::factory()->create();
        $jogadorUsuario = JogadorUsuario::factory()->create(['id_jogador' => $jogador->id, 'id_user' => $this->user->id]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/telaVender?id_jogador='.$jogador->id);
 
        $response->assertStatus(200);        
    }

    /*
    public function test_figurinhas_tela_visualizar(){
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/telaVisualizar');
 
        $response->assertStatus(200);        
    }
    */

    public function test_figurinhas_tela_procurar_propostas(){
        $this->seed(PosicoesTableSeeder::class);
        $this->seed(GruposTableSeeder::class);
        $this->seed(HandcapsTableSeeder::class);
        $this->seed(SelecoesTableSeeder::class);
        
        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO, 'cd_pagamento' => Pagamento::PAGO]);

        $jogador = Jogador::factory()->create();
        $jogador2 = Jogador::factory()->create();
        $jogadorUsuario = JogadorUsuario::factory()->create(['id_jogador' => $jogador->id, 'id_user' => $user1->id]);
        $jogadorUsuario2 = JogadorUsuario::factory()->create(['id_jogador' => $jogador2->id, 'id_user' => $this->user->id]);


        $transacaoFigurinha = TransacaoFigurinha::factory()->create(['id_user' => $user1->id, 'id_jogador' => $jogador->id]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/telaProcurarPropostas');
 
        $response->assertStatus(200);        
    }

    /*
    public function test_figurinhas_tela_ofertas_recebidas(){
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/telaOfertasRecebidas');
 
        $response->assertStatus(200);        
    }
    */

    public function test_figurinhas_tela_criar_proposta(){
        $this->seed(PosicoesTableSeeder::class);
        $this->seed(GruposTableSeeder::class);
        $this->seed(HandcapsTableSeeder::class);
        $this->seed(SelecoesTableSeeder::class);

        $jogador = Jogador::factory()->create();
        $jogador2 = Jogador::factory()->create();

        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO, 'cd_pagamento' => Pagamento::PAGO]);

        $jogadorUsuario1 = JogadorUsuario::factory()->create(['id_jogador' => $jogador->id, 'id_user' => $user1->id]);
        $jogadorUsuario2 = JogadorUsuario::factory()->create(['id_jogador' => $jogador2->id, 'id_user' => $this->user->id]);

        $transacaoFigurinha = TransacaoFigurinha::factory()->create(['id_user' => $user1->id, 'id_jogador' => $jogador->id]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/telaCriarProposta?id_oferta='.$transacaoFigurinha->id);
 
        
        $response->assertStatus(200);        
    }

    public function test_figurinhas_tela_propostas_recebidas_vazia(){
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/telaPropostasRecebidas');
 
        $response->assertStatus(302);        
    }

    public function test_figurinhas_tela_propostas_recebidas_com_proposta(){
        $this->seed(PosicoesTableSeeder::class);
        $this->seed(GruposTableSeeder::class);
        $this->seed(HandcapsTableSeeder::class);
        $this->seed(SelecoesTableSeeder::class);

        $jogador = Jogador::factory()->create();
        
        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO, 'cd_pagamento' => Pagamento::PAGO]);

        $jogadorUsuario = JogadorUsuario::factory()->create(['id_jogador' => $jogador->id, 'id_user' => $this->user->id]);
        
        $transacaoFigurinha = TransacaoFigurinha::factory()->create(['id_user' => $this->user->id, 'id_jogador' => $jogador->id]);
        $transacaoProposta = TransacaoProposta::factory()->create(['id_transacao' => $transacaoFigurinha->id, 'id_user_proposta' => $user1->id]);
        $proposta = PropostaJogador::factory()->create(['id_proposta' => $transacaoProposta->id, 'id_jogador' => $jogador->id]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/telaPropostasRecebidas');
 
        $response->assertStatus(200);        
    }

    public function test_figurinhas_visualizar_proposta(){
        $this->seed(PosicoesTableSeeder::class);
        $this->seed(GruposTableSeeder::class);
        $this->seed(HandcapsTableSeeder::class);
        $this->seed(SelecoesTableSeeder::class);

        $jogador = Jogador::factory()->create();
        $jogadorUsuario = JogadorUsuario::factory()->create(['id_jogador' => $jogador->id, 'id_user' => $this->user->id]);

        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO, 'cd_pagamento' => Pagamento::PAGO]);

        $transacaoFigurinha = TransacaoFigurinha::factory()->create(['id_user' => $user1->id, 'id_jogador' => $jogador->id]);
        $transacaoProposta = TransacaoProposta::factory()->create(['id_transacao' => $transacaoFigurinha->id, 'id_user_proposta' => $this->user->id]);
        $proposta = PropostaJogador::factory()->create(['id_proposta' => $transacaoProposta->id, 'id_jogador' => $jogador->id]);
        
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/visualizarProposta?id_proposta='.$proposta->id);
 
        $response->assertStatus(200);        
    }

    public function test_figurinhas_consulta_proposta(){
        $this->seed(PosicoesTableSeeder::class);
        $this->seed(GruposTableSeeder::class);
        $this->seed(HandcapsTableSeeder::class);
        $this->seed(SelecoesTableSeeder::class);

        $jogador = Jogador::factory()->create();
        $jogadorUsuario = JogadorUsuario::factory()->create(['id_jogador' => $jogador->id, 'id_user' => $this->user->id]);

        $user1 = User::factory()->create(['cd_perfil' => Perfil::PERFIL_USUARIO, 'cd_pagamento' => Pagamento::PAGO]);

        $transacaoFigurinha = TransacaoFigurinha::factory()->create(['id_user' => $user1->id, 'id_jogador' => $jogador->id]);
        $transacaoProposta = TransacaoProposta::factory()->create(['id_transacao' => $transacaoFigurinha->id, 'id_user_proposta' => $this->user->id]);
        $proposta = PropostaJogador::factory()->create(['id_proposta' => $transacaoProposta->id, 'id_jogador' => $jogador->id]);

        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/consultaProposta?id_proposta='.$proposta->id);
 
        $response->assertStatus(200);        
    }

    public function test_figurinhas_tela_recebidas_finalizadas(){
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/telaRecebidasFinalizadas');
 
        $response->assertStatus(200);        
    }

    public function test_figurinhas_tela_propostas_aceitas(){
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/telaPropostasAceitas');
 
        $response->assertStatus(200);        
    }

    public function test_figurinhas_tela_propostas_rejeitadas(){        
        $response = $this->actingAs($this->user)
                         ->withSession(['banned' => false])
                         ->get('/figurinhas/telaPropostasRejeitadas');
 
        $response->assertStatus(200);        
    }
}   

/*


// Figurinhas


Route::get('/figurinhas/listaPropostasTransacao', [FigurinhasController::class, 'listaPropostasTransacao'])->name('figurinhas.listaPropostasTransacao');
Route::get('/figurinhas/telaListarRepetidas', [FigurinhasController::class, 'telaListarRepetidas'])->name('figurinhas.telaListarRepetidas');
Route::get('/figurinhas/telaCancelarOferta', [FigurinhasController::class, 'telaCancelarOferta'])->name('figurinhas.telaCancelarOferta');
Route::get('/figurinhas/telaVerMinhasOfertas', [FigurinhasController::class, 'telaVerMinhasOfertas'])->name('figurinhas.telaVerMinhasOfertas');
Route::post('/figurinhas/cancelarOferta', [FigurinhasController::class, 'cancelarOferta'])->name('figurinhas.cancelarOferta');
Route::post('/figurinhas/visualizarOferta', [FigurinhasController::class, 'visualizarOferta'])->name('figurinhas.visualizarOferta');
Route::get('/figurinhas/telaOferecerFigurinha', [FigurinhasController::class, 'telaOferecerFigurinha'])->name('figurinhas.telaOferecerFigurinha');
Route::get('/figurinhas/oferecerFigurinha', [FigurinhasController::class, 'oferecerFigurinha'])->name('figurinhas.oferecerFigurinha');
Route::get('/figurinhas/telaPropostaRecebidaDetalhe', [FigurinhasController::class, 'telaPropostaRecebidaDetalhe'])->name('figurinhas.telaPropostaRecebidaDetalhe');
Route::get('/figurinhas/telaVerMinhasPropostas', [FigurinhasController::class, 'telaVerMinhasPropostas'])->name('figurinhas.telaVerMinhasPropostas');
Route::get('/figurinhas/telaVerMinhasPropostasDetalhe', [FigurinhasController::class, 'telaVerMinhasPropostasDetalhe'])->name('figurinhas.telaVerMinhasPropostasDetalhe');
Route::get('/figurinhas/telaEncerrarProposta', [FigurinhasController::class, 'telaEncerrarProposta'])->name('figurinhas.telaEncerrarProposta');
Route::post('/figurinhas/encerrarProposta', [FigurinhasController::class, 'encerrarProposta'])->name('figurinhas.encerrarProposta');
Route::get('/figurinhas/gerarAlbumPDF', [FigurinhasController::class, 'gerarAlbumPDF'])->name('figurinhas.gerarAlbumPDF');



*/