<?php

namespace App\Listeners;

use App\Events\JoiaPagaEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Mail\EmailRecibo;

class EnviaEmailReciboListener implements ShouldQueue
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
        Mail::to($event->usuario)->send(new EmailRecibo($event->usuario));        
    }
}