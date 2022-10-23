<?php

namespace App\Events;

use App\Models\User;

class ApostaAtualizadaEvent
{   
    public $user;
    public $tb_apostas;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $tb_apostas)
    {
        $this->user = $user;
        $this->tb_apostas = $tb_apostas;
    }   
}