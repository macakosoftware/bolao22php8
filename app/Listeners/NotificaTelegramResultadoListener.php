<?php

namespace App\Listeners;

use App\Events\ResultadoAtualizadoEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Telegram;

class NotificaTelegramResultadoListener implements ShouldQueue
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
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHAT_ID', ''),
            'parse_mode' => 'HTML',
            'text' => 'Resultados atualizados com sucesso!'
        ]);
    }
}