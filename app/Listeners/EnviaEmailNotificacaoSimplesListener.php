<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Models\User;
use App\Events\NotificacaoSimplesEvent;
use App\Mail\EmailNotificacaoSimples;

class EnviaEmailNotificacaoSimplesListener implements ShouldQueue
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
     * @param  \App\Events\NotificacaoSimplesEvent  $event
     * @return void
     */
    public function handle(NotificacaoSimplesEvent $event)
    {   
        if ($event->id_email){            
            $users = User::all();
            Mail::bcc($users)->send(new EmailNotificacaoSimples($event->notificacao));
        }
    }
}