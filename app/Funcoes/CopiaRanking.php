<?php

namespace App\Funcoes;

use App\Models\HistoricoRanking;
use App\Models\Ranking;

class CopiaRanking
{
    public $historico;
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Ranking $ranking)
    {
        $histRanking = new HistoricoRanking();
        $histRanking->dt_hr_ranking = date('Y-m-d H:i:s');
        $histRanking->cd_ranking = $ranking->cd_ranking;
        $histRanking->id_user = $ranking->id_user;
        $histRanking->qt_acertos_cheio = $ranking->qt_acertos_cheio;
        $histRanking->qt_acertos_parcial = $ranking->qt_acertos_parcial;
        $histRanking->qt_acertos_resultado = $ranking->qt_acertos_resultado;
        $histRanking->qt_pontos = $ranking->qt_pontos;
        $histRanking->qt_pontos_resultado = $ranking->qt_pontos_resultado;
        $histRanking->qt_pontos_placar_cheio = $ranking->qt_pontos_placar_cheio;
        $histRanking->qt_pontos_placar_parcial = $ranking->qt_pontos_placar_parcial;
        $histRanking->qt_pontos_maior = $ranking->qt_pontos_maior;
        $histRanking->qt_posicao = $ranking->qt_posicao;
        
        $this->historico = $histRanking;
    }
}
