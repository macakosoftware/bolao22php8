<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Events\ApostaAtualizadaEvent;
use App\Mail\EmailApostasEditadas;

class EnviaEmailApostasEditadasListener implements ShouldQueue
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
     * @param  \App\Events\ApostaAtualizadaEvent  $event
     * @return void
     */
    public function handle(ApostaAtualizadaEvent $event)
    {   
        //Mail::to($event->user)->send(new EmailApostasEditadas($event->user, $event->tb_apostas));
    }
}