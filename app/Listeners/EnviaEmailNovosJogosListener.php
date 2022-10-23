<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Events\NovoJogoEvent;
use App\Mail\EmailNovosJogos;
use App\Models\User;

class EnviaEmailNovosJogosListener implements ShouldQueue
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
     * @param  \App\Events\NovoJogoEvent  $event
     * @return void
     */
    public function handle(NovoJogoEvent $event)
    {   
        if ($event->id_notifica){            
            $users = User::all();
            Mail::bcc($users)->send(new EmailNovosJogos($event->jogo));
        }
    }
}