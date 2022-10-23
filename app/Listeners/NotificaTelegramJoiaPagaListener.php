<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Telegram;
use App\Events\NovoJogoEvent;
use App\Selecao;
use App\Events\JoiaPagaEvent;

class NotificaTelegramJoiaPagaListener implements ShouldQueue
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
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHAT_ID', ''),
            'parse_mode' => 'HTML',
            'text' => 'O usuário '.$event->usuario->name.' acaba de confirmar o pagamento da sua Joia Ingresso!'
        ]);
    }
}