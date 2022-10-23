<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\TipoRankingFechadoEvent;
use App\Funcoes\CalculaRanking;
use App\Funcoes\GeraBadge;
use App\Models\Badge;
use App\Models\BadgeUser;
use App\Models\TipoRanking;
use App\Models\FaseRanking;

class GeraTrofeuListener implements ShouldQueue
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
     * @param  \App\Events\TipoRankingFechadoEvent  $event
     * @return void
     */
    public function handle(TipoRankingFechadoEvent $event)
    {          
        $calculo = new CalculaRanking($event->tipoRanking->id);
        $calculo->recuperaPrimeiro();
        
        $trofeu = new GeraBadge($event->tipoRanking->id);
        $trofeu->gerar();
        
        $badge = new Badge();
        $badge->ds_nome = $event->tipoRanking->ds_nome;
        $badge->cd_ranking = $event->tipoRanking->id;
        $badge->id_posicao = 1;
        $badge->nr_posicao = 1;
        $badge->id_maior_pontuacao = false;
        $badge->id_placares_cheios = false;
        $badge->id_resultados = false;
        $badge->ds_link_badge = $trofeu->ds_imagem;
        $badge->save();
        
        if ($event->tipoRanking->tp_fase == TipoRanking::TIPO_FASE_COMPOSTO){
            $fases = FaseRanking::where('id_ranking_composto',$event->tipoRanking->id)->get();
            if (count($fases) > 0){
                foreach($fases as $fase){
                    $badgeAux = Badge::where('cd_ranking',$fase->id_ranking_simples)->first();
                    
                    $badgeUserAux = BadgeUser::where('id_badge',$badgeAux->id)
                                    ->where('id_user',$calculo->id_usuario_campeao)
                                    ->first();
                    if ($badgeUserAux != null){
                        $badgeUserAux->delete();                                    
                    }
                }
            }
        }
        
        $badgeUser = new BadgeUser();
        $badgeUser->id_badge = $badge->id;
        $badgeUser->id_user = $calculo->id_usuario_campeao;
        $badgeUser->save();
    }
}