<?php

namespace App\Events;

use App\Models\User;

class JoiaPagaEvent
{   
    public $usuario;
        
        /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $usuario)
    {
        $this->usuario = $usuario;
    }   
}