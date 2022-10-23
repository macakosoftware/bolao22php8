<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Events\ResultadoAtualizadoEvent;
use App\Mail\EmailInformeRanking;
use App\Models\User;

class EnviaEmailInformeRankingListener implements ShouldQueue
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
     * @param  \App\Events\ResultadoAtualizadoEvent  $event
     * @return void
     */
    public function handle(ResultadoAtualizadoEvent $event)
    {          
        $users = User::all();
        Mail::bcc($users)->send(new EmailInformeRanking());
    }
}