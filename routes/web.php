<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\Apostas\ApostasController;
use App\Http\Controllers\Jogos\JogosController;
use App\Http\Controllers\Notificacoes\NotificacoesController;
use App\Http\Controllers\Figurinhas\FigurinhasController;
use App\Http\Controllers\PontosXP\PontosXPController;
use App\Http\Controllers\Rankings\RankingsController;
use App\Http\Controllers\Selecoes\SelecoesController;
use App\Http\Controllers\Rankings\TiposRankingsController;
use App\Http\Controllers\Usuarios\UsuariosController;
use App\Http\Controllers\Usuarios\VotacoesController;
use App\Http\Controllers\Usuarios\MuralController;
use App\Http\Controllers\Jogadores\JogadoresController;
use App\Http\Controllers\Mensagens\MensagensController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', function () {
    return view('auth.login');
});
    
Route::get('/login', function () {
    return view('auth.login');
});


Auth::routes();

Route::get('/home', [HomeController::class,'index'])->name('home');

Route::get('/perfil', [PerfilController::class, 'telaPerfil'])->name('perfil');
Route::post('/alterarPerfil', [PerfilController::class, 'alterarPerfil'])->name('alterarPerfil');
Route::get('/trofeus', [PerfilController::class, 'telaTrofeus'])->name('trofeus');

// Regulamento
Route::get('/regulamento', [HomeController::class, 'regulamento'])->name('regulamento');

// Apostas
Route::get('/apostas/telaEditar', [ApostasController::class, 'telaEditar'])->name('apostas.telaEditar');
Route::post('/apostas/editar', [ApostasController::class, 'editar'])->name('apostas.editar');
Route::get('/apostas/telaMinhaConsultaLista', [ApostasController::class, 'telaMinhaConsultaLista'])->name('apostas.telaMinhaConsultaLista');
Route::get('/apostas/telaConsultaGeralLista', [ApostasController::class, 'telaConsultaGeralLista'])->name('apostas.telaConsultaGeralLista');
Route::get('/apostas/telaDetalhePalpite', [ApostasController::class, 'telaDetalhePalpite'])->name('apostas.telaDetalhePalpite');

// Rankings
Route::get('/rankings/telaFiltroConsulta', [RankingsController::class, 'telaFiltroConsulta'])->name('rankings.telaFiltroConsulta');
Route::post('/rankings/telaConsultaLista', [RankingsController::class, 'telaConsultaLista'])->name('rankings.telaConsultaLista');
Route::get('/rankings/telaFiltroInforme', [RankingsController::class, 'telaFiltroInforme'])->name('rankings.telaFiltroInforme');
Route::post('/rankings/gerarInforme', [RankingsController::class, 'gerarInforme'])->name('rankings.gerarInforme');
Route::get('/rankings/telaFiltroFechamento', [RankingsController::class, 'telaFiltroFechamento'])->name('rankings.telaFiltroFechamento');
Route::post('/rankings/gerarFechamento', [RankingsController::class, 'gerarFechamento'])->name('rankings.gerarFechamento');
Route::get('/rankings/telaFiltroCertificado', [RankingsController::class, 'telaFiltroCertificado'])->name('rankings.telaFiltroCertificado');
Route::post('/rankings/gerarCertificado', [RankingsController::class, 'gerarCertificado'])->name('rankings.gerarCertificado');

// Jogos
Route::get('/jogos/telaIncluir', [JogosController::class, 'telaIncluir'])->name('jogos.telaIncluir');
Route::post('/jogos/incluir', [JogosController::class, 'incluir'])->name('jogos.incluir');
Route::get('/jogos/telaConsultarLista', [JogosController::class, 'telaConsultarLista'])->name('jogos.telaConsultarLista');
Route::get('/jogos/telaManutencaoLista', [JogosController::class, 'telaManutencaoLista'])->name('jogos.telaManutencaoLista');
Route::get('/jogos/telaAlterar', [JogosController::class, 'telaAlterar'])->name('jogos.telaAlterar');
Route::post('/jogos/alterar', [JogosController::class, 'alterar'])->name('jogos.alterar');
Route::get('/jogos/telaExcluir', [JogosController::class, 'telaExcluir'])->name('jogos.telaExcluir');
Route::post('/jogos/excluir', [JogosController::class, 'excluir'])->name('jogos.excluir');
Route::get('/jogos/telaDetalhe', [JogosController::class, 'telaDetalhe'])->name('jogos.telaDetalhe');
Route::get('/jogos/telaResultados', [JogosController::class, 'telaResultados'])->name('jogos.telaResultados');
Route::post('/jogos/resultados', [JogosController::class, 'resultados'])->name('jogos.resultados');
//Route::get('/jogos/telaControleRanking', [JogosController::class, 'telaControleRanking'])->name('jogos.telaControleRanking');
Route::post('/jogos/controleRanking', [JogosController::class, 'controleRanking'])->name('jogos.controleRanking');
Route::post('/jogos/recalcular', [JogosController::class, 'recalcularHandcap'])->name('jogos.recalcular');
Route::get('/jogos/telaReciboPalpites', [JogosController::class, 'telaReciboPalpites'])->name('jogos.telaPalpiteRecibos');

// Seleções
Route::get('/selecoes/telaManutencao', [SelecoesController::class, 'telaManutencao'])->name('selecoes.telaManutencao');
Route::get('/selecoes/telaConsultaLista', [SelecoesController::class, 'telaConsultaLista'])->name('selecoes.telaConsultaLista');
Route::get('/selecoes/telaEditar', [SelecoesController::class, 'telaEditar'])->name('selecoes.telaEditar');
Route::post('/selecoes/editar', [SelecoesController::class, 'editar'])->name('selecoes.editar');
Route::post('/selecoes/manutencao', [SelecoesController::class, 'manutencao'])->name('selecoes.manutencao');
Route::post('/selecoes/incluir', [SelecoesController::class, 'incluir'])->name('selecoes.incluir');

// Tipos Rankings
Route::get('/tiposRankings/telaManutencaoLista', [TiposRankingsController::class, 'telaManutencaoLista'])->name('tiposRankings.telaManutencaoLista');
Route::get('/tiposRankings/telaControleRanking', [TiposRankingsController::class, 'telaControleRanking'])->name('tiposRankings.telaControleRanking');
Route::get('/tiposRankings/telaEditarTipo', [TiposRankingsController::class, 'telaEditarTipo'])->name('tiposRankings.telaEditarTipo');
Route::post('/tiposRankings/editarTipo', [TiposRankingsController::class, 'editarTipo'])->name('tiposRankings.editarTipo');
Route::post('/tiposRankings/controleRanking', [TiposRankingsController::class, 'controleRanking'])->name('tiposRankings.controleRanking');
Route::get('/tiposRankings/telaIncluir', [TiposRankingsController::class, 'telaIncluir'])->name('tiposRankings.telaIncluir');
Route::post('/tiposRankings/incluir', [TiposRankingsController::class, 'incluir'])->name('tiposRankings.incluir');

// Usuários
Route::get('/usuarios/telaIncluir', [UsuariosController::class, 'telaIncluir'])->name('usuario.telaIncluir');
Route::post('/usuarios/incluir', [UsuariosController::class, 'Incluir'])->name('usuario.incluir');
Route::get('/usuarios/telaManutencaoLista', [UsuariosController::class, 'telaManutencaoLista'])->name('usuario.telaManutencaoLista');
Route::get('/usuarios/telaAlterar', [UsuariosController::class, 'telaAlterar'])->name('usuario.telaAlterar');
Route::post('/usuarios/alterar', [UsuariosController::class, 'Alterar'])->name('usuario.alterar');
Route::get('/usuarios/telaExclusao', [UsuariosController::class, 'telaExclusao'])->name('usuario.telaExclusao');
Route::post('/usuarios/excluir', [UsuariosController::class, 'excluir'])->name('usuario.excluir');
Route::get('/usuarios/consultarLista', [UsuariosController::class, 'telaConsultarLista'])->name('usuario.telaConsultarLista');
Route::get('/usuarios/telaPagamentoSelecao', [UsuariosController::class, 'telaPagamentoSelecao'])->name('usuario.telaPagamentoSelecao');
Route::get('/usuarios/telaPagamentoDetalhe', [UsuariosController::class, 'telaPagamentoDetalhe'])->name('usuario.telaPagamentoDetalhe');
Route::post('/usuarios/incluirPagamento', [UsuariosController::class, 'incluirPagamento'])->name('usuario.incluirPagamento');
Route::get('/usuarios/telaReciboSelecao', [UsuariosController::class, 'telaReciboSelecao'])->name('usuario.telaReciboSelecao');
Route::post('/usuarios/imprimirRecibo', [UsuariosController::class, 'imprimirRecibo'])->name('usuario.imprimirRecibo');
Route::get('/usuarios/telaCriarNotificacao', [UsuariosController::class, 'telaCriarNotificacao'])->name('usuario.telaCriarNotificacao');
Route::post('/usuarios/criarNotificacao', [UsuariosController::class, 'criarNotificacao'])->name('usuario.criarNotificacao');
Route::get('/usuarios/telaCreditarPontosXP', [UsuariosController::class, 'telaCreditarPontosXP'])->name('usuario.telaCreditarPontosXP');
Route::post('/usuarios/creditarPontosXP', [UsuariosController::class, 'creditarPontosXP'])->name('usuario.creditarPontosXP');
Route::get('/usuarios/telaMural', [UsuariosController::class, 'telaMural'])->name('usuario.telaMural');
Route::post('/usuarios/atualizarMural', [UsuariosController::class, 'atualizarMural'])->name('usuarios.atualizarMural');
Route::get('/usuarios/desabilitarMural', [UsuariosController::class, 'desabilitarMural'])->name('usuarios.desabilitarMural');
Route::get('/usuarios/telaFiltroPremio', [UsuariosController::class, 'telaFiltroPremio'])->name('usuarios.telaFiltroPremio');
Route::get('/usuarios/telaSelecionarGanhador', [UsuariosController::class, 'telaSelecionarGanhador'])->name('usuarios.telaSelecionarGanhador');
Route::get('/usuarios/telaPremioDetalhe', [UsuariosController::class, 'telaPremioDetalhe'])->name('usuarios.telaPremioDetalhe');
Route::post('/usuarios/pagarPremio', [UsuariosController::class, 'pagarPremio'])->name('usuarios.pagarPremio');
Route::get('/usuarios/telaCriarVotacao', [UsuariosController::class, 'telaCriarVotacao'])->name('usuarios.telaCriarVotacao');
Route::post('/usuarios/incluirVotacao', [UsuariosController::class, 'incluirVotacao'])->name('usuarios.incluirVotacao');
Route::post('/usuarios/votar', [UsuariosController::class, 'votar'])->name('usuarios.votar');
Route::get('/usuarios/telaListaVotacoes', [UsuariosController::class, 'telaListaVotacoes'])->name('usuarios.telaListaVotacoes');
Route::get('/usuarios/detalharVotacao', [UsuariosController::class, 'detalharVotacao'])->name('usuarios.detalharVotacao');

// Votações
Route::get('/votacoes/telaListaVotacoes', [VotacoesController::class, 'telaListaVotacoes'])->name('votacoes.telaListaVotacoes');
Route::get('/votacoes/detalharVotacao', [VotacoesController::class, 'detalharVotacao'])->name('votacoes.detalharVotacao');

// Notificacoes
Route::get('/notificacoes/consultarListaNotificacoes', [NotificacoesController::class, 'consultarListaNotificacoes'])->name('notificacoes.consultarListaNotificacoes');
Route::get('/notificacoes/telaConsultaNotSimples', [NotificacoesController::class, 'telaConsultaNotSimples'])->name('notificacoes.telaConsultaNotSimples');

// Mural
Route::post('/mural/postar', [MuralController::class, 'postar'])->name('mural.postar');

// Jogadores
Route::get('/jogadores/telaImportar', [JogadoresController::class, 'telaImportar'])->name('jogadores.telaImportar');
Route::post('/jogadores/importar', [JogadoresController::class, 'importar'])->name('jogadores.importar');
Route::get('/jogadores/teste', [JogadoresController::class, 'teste'])->name('jogadores.teste');

// Pontos XP
Route::get('/pontosXP/resumoUsuario', [PontosXPController::class, 'resumoUsuario'])->name('pontosXP.resumoUsuario');
Route::get('/pontosXP/montaCedula', [PontosXPController::class, 'montaCedula'])->name('pontosXP.montaCedula');

// Figurinhas
Route::get('/figurinhas/telaCompra', [FigurinhasController::class, 'telaCompra'])->name('figurinhas.telaCompra');
Route::post('/figurinhas/comprar', [FigurinhasController::class, 'comprar'])->name('figurinhas.comprar');
Route::get('/figurinhas/mostrar', [FigurinhasController::class, 'mostrar'])->name('figurinhas.mostrar');
Route::get('/figurinhas/telaListarMinhas', [FigurinhasController::class, 'telaListarMinhas'])->name('figurinhas.telaListarMinhas');
Route::get('/figurinhas/verAlbum', [FigurinhasController::class, 'verAlbum'])->name('figurinhas.verAlbum');
Route::get('/figurinhas/telaResumo', [FigurinhasController::class, 'telaResumo'])->name('figurinhas.telaResumo');
Route::get('/figurinhas/telaTrocar', [FigurinhasController::class, 'telaTrocar'])->name('figurinhas.telaTrocar');
Route::post('/figurinhas/trocar', [FigurinhasController::class, 'trocar'])->name('figurinhas.trocar');
Route::get('/figurinhas/telaVender', [FigurinhasController::class, 'telaVender'])->name('figurinhas.telaVender');
Route::post('/figurinhas/vender', [FigurinhasController::class, 'vender'])->name('figurinhas.vender');
//Route::get('/figurinhas/telaVisualizar', [FigurinhasController::class, 'telaVisualizar'])->name('figurinhas.telaVisualizar');
Route::get('/figurinhas/telaProcurarPropostas', [FigurinhasController::class, 'telaProcurarPropostas'])->name('figurinhas.telaProcurarPropostas');
//Route::get('/figurinhas/telaOfertasRecebidas', [FigurinhasController::class, 'telaOfertasRecebidas'])->name('figurinhas.telaOfertasRecebidas');
Route::get('/figurinhas/telaCriarProposta', [FigurinhasController::class, 'telaCriarProposta'])->name('figurinhas.telaCriarProposta');
Route::post('/figurinhas/criarProposta', [FigurinhasController::class, 'criarProposta'])->name('figurinhas.criarProposta');
Route::get('/figurinhas/telaPropostasRecebidas', [FigurinhasController::class, 'telaPropostasRecebidas'])->name('figurinhas.telaPropostasRecebidas');
Route::get('/figurinhas/visualizarProposta', [FigurinhasController::class, 'visualizarProposta'])->name('figurinhas.visualizarProposta');
Route::get('/figurinhas/consultaProposta', [FigurinhasController::class, 'consultaProposta'])->name('figurinhas.consultaProposta');
Route::post('/figurinhas/atualizarProposta', [FigurinhasController::class, 'atualizarProposta'])->name('figurinhas.atualizarProposta');
Route::get('/figurinhas/telaRecebidasFinalizadas', [FigurinhasController::class, 'telaRecebidasFinalizadas'])->name('figurinhas.telaRecebidasFinalizadas');
Route::get('/figurinhas/telaPropostasAceitas', [FigurinhasController::class, 'telaPropostasAceitas'])->name('figurinhas.telaPropostasAceitas');
Route::get('/figurinhas/telaPropostasRejeitadas', [FigurinhasController::class, 'telaPropostasRejeitadas'])->name('figurinhas.telaPropostasRejeitadas');
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

//Mensagens
Route::get('/mensagens/telaNovaMensagem', [MensagensController::class, 'telaNovaMensagem'])->name('mensagens.telaNovaMensagem');
Route::post('/mensagens/enviar', [MensagensController::class, 'enviar'])->name('mensagens.enviar');
Route::get('/mensagens/telaVerMensagem', [MensagensController::class, 'telaVerMensagem'])->name('mensagens.telaVerMensagem');
Route::get('/mensagens/tratarMensagem', [MensagensController::class, 'tratarMensagem'])->name('mensagens.tratarMensagem');
Route::post('/mensagens/enviarResposta', [MensagensController::class, 'enviarResposta'])->name('mensagens.enviarResposta');
Route::get('/mensagens/telaConsultarMensagens', [MensagensController::class, 'telaConsultarMensagens'])->name('mensagens.telaConsultarMensagens');