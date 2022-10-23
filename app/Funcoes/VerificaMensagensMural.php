<?php

namespace App\Funcoes;

use App\Models\MensagemMural;
use App\Models\User;

class VerificaMensagensMural
{
    private const NUMERO_MSGS_MURAL = 10;
    
    public $id_mensagens;
    public $qt_mensagens;
    public $mensagens;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->id_mensagens = false;
        $this->qt_mensagens = 0;
    }
    
    public function verificar(User $user){
        
        $mensagens = MensagemMural::where('id','>',0)
        ->orderBy('updated_at','DESC')
        ->get();
        if (count($mensagens) > 0){
            $this->id_mensagens = true;
            
            foreach($mensagens as $mensagem){
                $this->qt_mensagens++;
                $this->mensagens[] = $mensagem;
                if ($this->qt_mensagens >= $this::NUMERO_MSGS_MURAL){
                    break;
                }
            }
        }
        
        return $this->id_mensagens;
    }
    
}
