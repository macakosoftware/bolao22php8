<?php

namespace App\Events;

use App\Models\User;
use App\Models\Premio;

class PremioPagoEvent
{   
    public $premio;
        
        /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Premio $premio)
    {
        $this->premio = $premio;
    }   
}