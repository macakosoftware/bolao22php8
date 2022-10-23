<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Models\User;
use App\Events\TipoRankingFechadoEvent;
use App\Mail\EmailFechamentoRanking;

class EnviaEmailFechamentoRankingListener implements ShouldQueue
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
        $users = User::all();
        Mail::bcc($users)->send(new EmailFechamentoRanking($event->tipoRanking));
    }
}