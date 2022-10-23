<?php

namespace App\Listeners;

use App\Events\UsuarioIncluidoEvent;
use App\Mail\EmailBoasVindas;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class EnviaEmailBoasVindasListener implements ShouldQueue
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
     * @param  \App\Events\UsuarioIncluidoEvent  $event
     * @return void
     */
    public function handle(UsuarioIncluidoEvent $event)
    {   
        Mail::to($event->user)->send(new EmailBoasVindas($event->user, $event->senha));
    }
}