<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Models\User;
use App\Mail\EmailPremio;
use App\Events\PremioPagoEvent;

class EnviaEmailPremioListener implements ShouldQueue
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
     * @param  \App\Events\PremioPagoEvent  $event
     * @return void
     */
    public function handle(PremioPagoEvent $event)
    {   
        $users = User::all();
        Mail::bcc($users)->send(new EmailPremio($event->premio));        
    }
}