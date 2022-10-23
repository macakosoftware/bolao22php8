<?php

namespace App\Events;

use App\Models\TipoRanking;

class TipoRankingFechadoEvent
{   
    public $tipoRanking;
        
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(TipoRanking $tipoRanking)
    {
        $this->tipoRanking = $tipoRanking;
    }   
}