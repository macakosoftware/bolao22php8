<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Telegram;
use App\Events\ApostaAtualizadaEvent;

class NotificaTelegramApostaEditadaListener implements ShouldQueue
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
        $qt_apostas = count($event->tb_apostas);
        $usuario = $event->user;
        
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHAT_ID', ''),
            'parse_mode' => 'HTML',
            'text' => $usuario->name.' acaba de atualizar '.$qt_apostas.' palpite(s)!'
        ]);
        
    }
}