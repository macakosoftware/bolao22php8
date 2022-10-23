<?php

namespace App\Http\Controllers;

use App\Models\Jogo;
use App\Models\StatusJogo;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Ranking;
use App\Models\TipoRanking;
use Storage;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\Pagamento;
use App\Models\Aposta;
use App\Models\Mural;
use App\Funcoes\CalculaRanking;
use App\Models\HistoricoRanking;
use App\Models\Premio;
use App\Models\Pool;
use App\Models\PoolVoto;
use App\Models\PoolValor;

class HomeController extends LogadoController
{
    private const NUMERO_EXIBE_RANKING_GERAL = 5;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $id_autorizado = true;
        if ($request->has('nao_autorizado')){
            $id_autorizado = false;
        }
        
        $jogos = Jogo::where('cd_status', StatusJogo::JOGO_PROGRAMADO)->get();
        
        $usuarios = User::all();
        
        $i_jogo = 0;
        foreach($jogos as $jogo){
            $i_jogo++;
            if ($i_jogo > 5){
                break;
            }            
            $tb_jogos[] = $jogo;            
        }
        
        $vl_para_premios = 0;
        foreach($usuarios as $usuario){
            if ($usuario->cd_pagamento == Pagamento::PAGO){
                $vl_para_premios += $usuario->vl_pagamento;
            }
        }
        
        $todasApostas = Aposta::all();
        $qt_palpites = count($todasApostas);
        $todosJogos = Jogo::all();
        $qt_jogos = count($todosJogos);
        $qt_previsao_palpites = $qt_jogos * count($usuarios);
        if ($qt_previsao_palpites == 0){
        	$pc_apostas_feitas = 0;
        }
        else {
        	$pc_apostas_feitas = ($qt_palpites / $qt_previsao_palpites) * 100;
        }
        $qt_apostas_pendentes = $qt_previsao_palpites - $qt_palpites;
        
        $premios = Premio::all();
        $vl_premios = 0;
        if (count($premios) > 0){
            foreach($premios as $premio){
                $vl_premios += $premio->vl_premio;
            }
        }
        
        
        view()->share('id_autorizado',$id_autorizado);
        view()->share('nr_jogos_programados', count($jogos));
        view()->share('nr_usuarios', count($usuarios));
        view()->share('qt_apostas_feitas', $qt_palpites);
        view()->share('vl_para_premios', $vl_para_premios);
        view()->share('vl_premios_pagos', $vl_premios);
        view()->share('pc_apostas_feitas', $pc_apostas_feitas);
        view()->share('qt_apostas_pendentes', $qt_apostas_pendentes);
        view()->share('tb_jogos', $jogos);
        
        $rankings = CalculaRanking::queryRanking(env('CLASSIFICACAO_GERAL','1'));
        
        $id_ranking = false;            
        $tb_ranking = array();
        if (count($rankings) > 0){
            $id_ranking = true;
            
            foreach($rankings as $ranking){
                
                $hist = HistoricoRanking::where('cd_ranking',$ranking->cd_ranking)
                ->where('id_user',$ranking->id_user)
                ->orderBy('dt_hr_ranking','desc')
                ->first();
                $dif = 0;
                $id_sobe = false;
                $id_desce = false;
                if ($hist != null){
                    if ($hist->qt_posicao != 0){
                        $dif = $ranking->qt_posicao - $hist->qt_posicao;
                        if ($dif < 0){
                            $dif = $dif * -1;
                            $id_sobe = true;
                        }
                        else if ($dif > 0){
                            $id_desce = true;
                        }
                    }
                }
                
                $id_avatar_participante = false;
                
                $tb_ranking[] = array('nr_posicao'=>$ranking->qt_posicao,
                    'ds_nome'=>$ranking->usuario->name,
                    'qt_pontos'=>$ranking->qt_pontos,
                    'qt_acertos_resultado'=>$ranking->qt_acertos_resultado,
                    'qt_acertos_cheio'=>$ranking->qt_acertos_cheio,
                    'qt_acertos_parcial'=>$ranking->qt_acertos_parcial,
                    'qt_pontos_resultado'=>$ranking->qt_pontos_resultado,
                    'qt_pontos_placar_cheio'=>$ranking->qt_pontos_placar_cheio,
                    'qt_pontos_placar_parcial'=>$ranking->qt_pontos_placar_parcial,
                    'qt_pontos_maior'=>$ranking->qt_pontos_maior,
                    'qt_apostas'=>$ranking->qt_apostas,                                        
                    'id_ranking'=>env('CLASSIFICACAO_GERAL','1'),
                    'id_user'=>$ranking->usuario->id,
                    'id_sobe'=>$id_sobe,
                    'id_desce'=>$id_desce,
                    'dif'=>$dif
                );
                if ($ranking->qt_posicao >= $this::NUMERO_EXIBE_RANKING_GERAL){
                    break;
                }
            }
            view()->share('tb_ranking',$tb_ranking);
        }
        
        view()->share('id_ranking',$id_ranking);
        
        $mural = Mural::where('id','>',0)
                 ->orderBy('updated_at','DESC')
                 ->first();
        
        $id_mural_comum = false;
        $ds_mural_comum = '';
        if (isset($mural)){
            if (trim($mural->ds_mensagem) != ""){
                $id_mural_comum = true;
                $ds_mural_comum = $mural->ds_mensagem;
            }
        }
        view()->share('id_mural_comum',$id_mural_comum);
        view()->share('ds_mural_comum',$ds_mural_comum);
        
        $qt_votacoes = 0;        
        $votacoes = Pool::where('id','>',0)->get();
        $tb_votacoes = array();
        foreach($votacoes as $votacao){            
            $voto = PoolVoto::where('id_pool',$votacao->id)
            ->where('id_user',$this->usuario->id)
            ->first();
            if ($voto == null){
                $qt_votacoes++;                
                $valores = PoolValor::where('id_pool',$votacao->id)->get();
                $tb_votacoes[] = array('nr' => $qt_votacoes,
                    'votacao' => $votacao,
                    'valores' => $valores);
            }
        }
        view()->share('qt_votacoes',$qt_votacoes);
        if ($qt_votacoes > 0){
            view()->share('tb_votacoes',$tb_votacoes);
        }
        
        return view('home');
    }
    
    public function regulamento(){
        return view('regulamento');
    }
}
