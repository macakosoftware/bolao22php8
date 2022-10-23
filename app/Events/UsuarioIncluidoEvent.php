<?php

namespace App\Events;

use App\Models\User;

class UsuarioIncluidoEvent
{   
    public $user;
    public $senha;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $senha)
    {
        $this->user = $user;
        $this->senha = $senha;
    }   
}