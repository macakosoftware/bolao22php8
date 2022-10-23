<?php

namespace App\Funcoes;

use App\Models\Mensagem;
use App\Models\User;
use App\Models\Destinatario;

class VerificaMensagens
{
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
        
        $mensagens = Destinatario::where('id_user',$user->id)
                     ->where('id_lido',false)
                     ->with('mensagem')                     
                     ->get();
                     
        $this->qt_mensagens = count($mensagens);
        if (count($mensagens) > 0){
            $this->id_mensagens = true;
            $this->mensagens = $mensagens;
        }
        
        return $this->id_mensagens;
    }
}
