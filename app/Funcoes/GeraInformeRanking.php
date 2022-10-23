<?php

namespace App\Funcoes;

use App\Models\TipoRanking;
use PDF;
use App\Models\HistoricoRanking;

class GeraInformeRanking 
{
    private const DIRETORIO_TMP ='/tmp';
    
    public $tb_rankings;
    public $pdf;    
    public $ds_arquivo;
            
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($tb_rankings)    
    {                
        $this->tb_rankings = $tb_rankings;
    }
    
    public function gerar(){   
        sort($this->tb_rankings);
        
        $rankings = array();
        foreach($this->tb_rankings as $id_ranking){
            
            $tipoRanking = TipoRanking::where('id',$id_ranking)->first();
            
            $rankingsDB = CalculaRanking::queryRanking($id_ranking);
                        
            $tem_ranking = false;
            
            if (count($rankingsDB) > 0){
                $tem_ranking = true;
                if (isset($tb_usuarios)){
                    unset($tb_usuarios);
                }
                
                $tb_usuarios = array();
                foreach($rankingsDB as $ranking){                
                    
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
                    
                    $tb_usuarios[] = array('nr_posicao'=>$ranking->qt_posicao,
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
                        'id_ranking'=>$ranking->cd_ranking,
                        'id_user'=>$ranking->usuario->id,
                        'id_sobe'=>$id_sobe,
                        'id_desce'=>$id_desce,
                        'dif'=>$dif
                    );
                }                
            }
            else {
                $tb_usuarios = array();
            }
            
            $rankings[] = array('id_ranking'=>$id_ranking,
                                'ds_nome'=>$tipoRanking->ds_nome,
                                'tem_ranking'=>$id_ranking,
                                'tb_usuarios'=>$tb_usuarios
            );
        }
        
        view()->share('rankings',$rankings);

        $this->ds_arquivo = $this::DIRETORIO_TMP.'/'.date('Y-m-d').'_'.date('H:i:s').'_informe_atualizado.pdf';        
        $this->pdf = PDF::loadView('domPdf.informeRanking');
    }
}
