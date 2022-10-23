<?php

namespace App\Listeners;

use App\Events\JoiaPagaEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use App\Models\HistoricoPontoXP;

class CreditaPontosXPPagamentoListener implements ShouldQueue
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
     * @param  \App\Events\JoiaPagaEvent  $event
     * @return void
     */ 
    public function handle(JoiaPagaEvent $event)
    {   
        $event->usuario->qt_pontos_xp += User::PONTOS_PAGAMENTO;
        $event->usuario->save();
        
        $hist = new HistoricoPontoXP();
        $hist->id_user = $event->usuario->id;        
        $hist->tp_transacao = HistoricoPontoXP::TIPO_ENTRADA;
        $hist->dt_transacao = date('Y-m-d');
        $hist->ds_transacao = 'Crédito de 100 Brochetas relativo ao pagamento da Joia';
        $hist->vl_transacao = User::PONTOS_PAGAMENTO;
        $hist->save();
    }
}