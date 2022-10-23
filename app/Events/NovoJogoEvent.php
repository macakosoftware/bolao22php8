<?php

namespace App\Events;

use App\Models\Jogo;

class NovoJogoEvent
{   
    public $jogo;
    public $id_notifica;
    
        /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Jogo $jogo, $id_notifica)
    {
        $this->jogo = $jogo;        
        $this->id_notifica = $id_notifica;
    }   
}