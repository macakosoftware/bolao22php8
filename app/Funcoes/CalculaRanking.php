<?php

namespace App\Funcoes;

use App\Models\Ranking;
use App\Models\TipoRanking;
use App\Models\FaseRanking;

class CalculaRanking 
{
    public const TRIPLETE = "TRIPLETE";
    public const DOBLETE_A = "DOBLETE A";
    public const DOBLETE_B = "DOBLETE B";
    public const CAMPEAO_RODADA = "CAMPEÃO DA RODADA";
    
    public $id_usuario_campeao;
    public $id_usuario_2;
    public $id_usuario_3;
    public $usuario_campeao;
    public $usuario_2;
    public $usuario_3;
    public $qt_pontos;
    public $qt_pontos_2;
    public $qt_pontos_3;
    public $cd_ranking;
    public $id_serie_A;
    public $id_serie_B;
    public $ds_tipo_certificado;
    public $tp_ranking;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($cd_ranking)    
    {                
        $this->cd_ranking = $cd_ranking;
    }
    
    public function recuperaPrimeiro(){
        
    	$tipoRanking = TipoRanking::where('id', $this->cd_ranking)->first();
    	
        $ranking = CalculaRanking::getFirstRanking($this->cd_ranking);
        
        $this->usuario_campeao = $ranking->usuario;
        $this->id_usuario_campeao = $ranking->usuario->id;
        $this->qt_pontos = $ranking->qt_pontos;
        $this->tp_ranking = $tipoRanking->tp_fase;
        
        if ($tipoRanking->tp_fase == TipoRanking::TIPO_FASE_COMPOSTO){
            $this->id_serie_A = false;
            $this->id_serie_B = false;
            $fases = FaseRanking::where('id_ranking_composto',$this->cd_ranking)->get();
            foreach($fases as $fase){            
            	$rankingSimples = Ranking::where('cd_ranking',$fase->id_ranking_simples)
            	->with('tipoRanking')
            	->with('usuario')
            	->orderBy('qt_pontos', 'desc')
                ->orderBy('qt_acertos_cheio', 'desc')
                ->orderBy('qt_acertos_parcial', 'desc')
                ->orderBy('qt_acertos_resultado', 'desc')
                ->orderBy('qt_pontos_maior', 'desc')
            	->first();
            	
            	if ($rankingSimples->usuario->id == $this->id_usuario_campeao){        	    
    	        	if ($rankingSimples->tipoRanking->tp_serie == TipoRanking::TIPO_SERIE_A){	        	    
    	        		$this->id_serie_A = true;
    	        	}	        	
    	        	if ($rankingSimples->tipoRanking->tp_serie == TipoRanking::TIPO_SERIE_B){	        	    
    	        		$this->id_serie_B = true;
    	        	}
            	}
            }
            
            $this->ds_tipo_certificado = "";
            if ($this->id_serie_A && $this->id_serie_B){
                $this->ds_tipo_certificado = $this::TRIPLETE;
            }
            else if ($this->id_serie_A){
                $this->ds_tipo_certificado = $this::DOBLETE_A;
            }
            else if ($this->id_serie_B){
                $this->ds_tipo_certificado = $this::DOBLETE_B;
            }
            else {
                $this->ds_tipo_certificado = $this::CAMPEAO_RODADA;
            }
        }
        
        if ($tipoRanking->tp_fase == TipoRanking::TIPO_FASE_GERAL){
            $todoRanking = CalculaRanking::getAllRanking($this->cd_ranking);
            $nr_posicao = 0;
            $this->ds_tipo_certificado = "Classificação Geral";
            foreach($todoRanking as $regRanking){
                $nr_posicao++;
                if ($nr_posicao == 1){
                }
                else if ($nr_posicao == 2){
                    $this->usuario_2 = $regRanking->usuario;
                    $this->id_usuario_2 = $regRanking->usuario->id;
                    $this->qt_pontos_2 = $regRanking->qt_pontos;                    
                }
                else if ($nr_posicao == 3){
                    $this->usuario_3 = $regRanking->usuario;
                    $this->id_usuario_3 = $regRanking->usuario->id;
                    $this->qt_pontos_3 = $regRanking->qt_pontos;                    
                }
                else {
                    break;
                }
            }
        }
    }
    
    protected static function montaQuery($cd_ranking){
        return  Ranking::where('cd_ranking',$cd_ranking)
        ->with('tipoRanking')
        ->with('usuario')
        ->orderBy('qt_pontos', 'desc')
        ->orderBy('qt_acertos_cheio', 'desc')
        ->orderBy('qt_acertos_parcial', 'desc')
        ->orderBy('qt_acertos_resultado', 'desc')
        ->orderBy('qt_pontos_maior', 'desc');        
    }
    
    public static function getFirstRanking($cd_ranking){
       return CalculaRanking::montaQuery($cd_ranking)->first();
    }
    
    public static function getAllRanking($cd_ranking){
       return CalculaRanking::montaQuery($cd_ranking)->get();
    }
    
    public static function queryRanking($cd_ranking){
       return CalculaRanking::montaQuery($cd_ranking)->get();        
    }
}
