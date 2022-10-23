<?php

namespace App\Listeners;

use App\Models\Aposta;
use App\Models\Jogo;
use App\Models\Ranking;
use App\Models\StatusJogo;
use App\Models\StatusRanking;
use App\Models\TipoRanking;
use App\Models\User;
use App\Events\ResultadoAtualizadoEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Funcoes\CalculaResultado;
use App\Funcoes\CopiaRanking;
use App\Models\FaseRanking;
use App\Funcoes\CalculaRanking;

class AtualizaRankingListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ResultadoAtualizadoEvent  $event
     * @return void
     */
    public function handle(ResultadoAtualizadoEvent $event)
    {
        $tipos = TipoRanking::where('cd_status',StatusRanking::ABERTO)
                 ->where('id','<>',env('CLASSIFICACAO_GERAL','1'))
                 ->get();
        
        foreach($tipos as $tipo){            
            $usuarios = User::all();
            foreach($usuarios as $usuario){
                
                $ranking = Ranking::where('cd_ranking',$tipo->id)
                           ->where('id_user',$usuario->id)
                           ->first();
                if ($ranking != null){
                    $copia = new CopiaRanking($ranking);
                    $copia->historico->save();   
                    
                    $ranking->delete();
                }
                
                $jogos = Jogo::where('cd_status',StatusJogo::JOGO_FINALIZADO)
                               ->where('cd_ranking',$tipo->id)
                               ->get();
                
                $qt_pontos_total = 0;
                $qt_pontos_resultado = 0;
                $qt_pontos_placar_cheio = 0;
                $qt_pontos_placar_parcial = 0;
                $qt_pontos_maior = 0;
                
                $qt_acertos_resultado = 0;
                $qt_acertos_cheio = 0;
                $qt_acertos_parcial = 0;
                
                $qt_apostas = 0;
                
                foreach($jogos as $jogo){
                    $aposta = Aposta::where('id_jogo', $jogo->id)
                              ->where('id_user', $usuario->id)
                              ->first();
                    
                    if ($aposta != null){
                        $qt_apostas++;
                        $calculo = new CalculaResultado();
                        $calculo->calcular($aposta->id);
                        
                        $qt_pontos_total += $calculo->qt_pontos_total;
                        $qt_pontos_resultado += $calculo->qt_pontos_resultado;
                        $qt_pontos_placar_cheio += $calculo->qt_pontos_placar_cheio;
                        $qt_pontos_placar_parcial += $calculo->qt_pontos_placar_parcial;
                        if ($calculo->qt_pontos_total > $qt_pontos_maior){
                            $qt_pontos_maior = $calculo->qt_pontos_total;
                        }
                        if ($calculo->id_resultado){
                            $qt_acertos_resultado++;
                        }
                        if ($calculo->id_placar_cheio){
                            $qt_acertos_cheio++;
                        }
                        if ($calculo->id_placar_parcial){
                            $qt_acertos_parcial++;
                        }
                    }
                }
                
                $ranking = new Ranking();
                $ranking->cd_ranking  = $tipo->id;
                $ranking->id_user = $usuario->id;
                $ranking->qt_acertos_cheio = $qt_acertos_cheio;
                $ranking->qt_acertos_parcial = $qt_acertos_parcial;
                $ranking->qt_acertos_resultado = $qt_acertos_resultado;
                $ranking->qt_pontos = $qt_pontos_total;
                $ranking->qt_pontos_resultado = $qt_pontos_resultado;
                $ranking->qt_pontos_placar_cheio = $qt_pontos_placar_cheio;
                $ranking->qt_pontos_placar_parcial = $qt_pontos_placar_parcial;
                $ranking->qt_pontos_maior = $qt_pontos_maior;
                $ranking->qt_apostas = $qt_apostas;
                $ranking->qt_posicao = 0;
                $ranking->save();
            }
            
            $qt_posicao = 0;
            $rankings = CalculaRanking::queryRanking($tipo->id);
            foreach($rankings as $ranking){
                $qt_posicao++;
                $ranking->qt_posicao = $qt_posicao;
                $ranking->save();
            }
        }
        
        // Gera Ranking Geral
        $usuarios = User::all();
        foreach($usuarios as $usuario){
           $ranking = Ranking::where('id_user', $usuario->id)
                       ->where('cd_ranking',env('CLASSIFICACAO_GERAL','1'))
                       ->first();
           if ($ranking != null){
               $copia = new CopiaRanking($ranking);
               $copia->historico->save();
               
               $ranking->delete();
           }
            
           $rankings = Ranking::where('id_user', $usuario->id)
                       ->with('tipoRanking')
                       ->get();
           
           $qt_acertos_cheio = 0;
           $qt_acertos_parcial = 0;
           $qt_acertos_resultado = 0;
           $qt_pontos = 0;
           $qt_pontos_resultado = 0;
           $qt_pontos_placar_cheio = 0;
           $qt_pontos_placar_parcial = 0;
           $qt_pontos_maior = 0;
           $qt_apostas = 0;
           
           foreach ($rankings as $ranking){
           	if ($ranking->tipoRanking->tp_fase == TipoRanking::TIPO_FASE_SIMPLES){
	               $qt_acertos_cheio += $ranking->qt_acertos_cheio;
	               $qt_acertos_parcial += $ranking->qt_acertos_parcial;
	               $qt_acertos_resultado += $ranking->qt_acertos_resultado;
	               $qt_pontos += $ranking->qt_pontos;
	               $qt_pontos_resultado += $ranking->qt_pontos_resultado;
	               $qt_pontos_placar_cheio += $ranking->qt_pontos_placar_cheio;
	               $qt_pontos_placar_parcial += $ranking->qt_pontos_placar_parcial;
	               if ($ranking->qt_pontos_maior > $qt_pontos_maior){
	                  $qt_pontos_maior = $ranking->qt_pontos_maior;
	               }
	               $qt_apostas += $ranking->qt_apostas;
           	}
           }
           
           $ranking = new Ranking();
           $ranking->cd_ranking  = env('CLASSIFICACAO_GERAL','1');
           $ranking->id_user = $usuario->id;
           $ranking->qt_acertos_cheio = $qt_acertos_cheio;
           $ranking->qt_acertos_parcial = $qt_acertos_parcial;
           $ranking->qt_acertos_resultado = $qt_acertos_resultado;
           $ranking->qt_pontos = $qt_pontos;
           $ranking->qt_pontos_resultado = $qt_pontos_resultado;
           $ranking->qt_pontos_placar_cheio = $qt_pontos_placar_cheio;
           $ranking->qt_pontos_placar_parcial = $qt_pontos_placar_parcial;
           $ranking->qt_pontos_maior = $qt_pontos_maior;
           $ranking->qt_apostas = $qt_apostas;
           $ranking->qt_posicao = 0;
           $ranking->save();
        }
        
        $qt_posicao = 0;
        $rankings = CalculaRanking::queryRanking(env('CLASSIFICACAO_GERAL','1'));
        foreach($rankings as $ranking){
            $qt_posicao++;
            $ranking->qt_posicao = $qt_posicao;
            $ranking->save();
        }
    }
}