<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Events\TipoRankingFechadoEvent;
use App\Funcoes\CalculaRanking;
use App\Mail\EmailCertificadoRanking;
use App\Models\TipoRanking;
use App\Mail\EmailCertificadoRanking2;
use App\Mail\EmailCertificadoRanking3;

class EnviaEmailCertificadoListener implements ShouldQueue
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
        if ($event->tipoRanking->tp_fase == TipoRanking::TIPO_FASE_COMPOSTO ||
            $event->tipoRanking->tp_fase == TipoRanking::TIPO_FASE_GERAL){
        
            $calculo = new CalculaRanking($event->tipoRanking->id);
            $calculo->recuperaPrimeiro();
                        
            Mail::to($calculo->usuario_campeao)->send(new EmailCertificadoRanking($event->tipoRanking, $calculo->usuario_campeao));
            
            if ($event->tipoRanking->tp_fase == TipoRanking::TIPO_FASE_GERAL){
                Mail::to($calculo->usuario_2)->send(new EmailCertificadoRanking2($event->tipoRanking, $calculo->usuario_2));
                
                Mail::to($calculo->usuario_3)->send(new EmailCertificadoRanking3($event->tipoRanking, $calculo->usuario_3));
            }
        }
    }
}