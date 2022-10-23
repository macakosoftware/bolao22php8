<?php

namespace App\Events;

use App\Models\Notificacao;

class NotificacaoSimplesEvent
{   
    public $notificacao;
    public $id_email;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Notificacao $notificacao, $id_email)
    {
        $this->notificacao = $notificacao;
        $this->id_email = $id_email;
    }   
}