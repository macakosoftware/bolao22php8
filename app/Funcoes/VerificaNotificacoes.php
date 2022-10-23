<?php

namespace App\Funcoes;

use App\Models\Notificacao;
use App\Models\NotificacaoLida;
use App\Models\User;

class VerificaNotificacoes
{
    private const NUMERO_NOTIFICACOES = 5;
 
    public $id_notificacao;
    public $qt_notificacoes;
    public $notificacoes;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->id_notificacao = false;
        $this->qt_notificacoes = 0;
        $this->notificacoes = array();
    }
    
    public function verificar(User $id_user){
        
        $notificacoes = Notificacao::where('id','>',0)->orderBy('updated_at')->get();
            
        foreach($notificacoes as $notificacao){
            
            $lida = NotificacaoLida::where('id_notificacao',$notificacao->id)
                    ->where('id_user',$id_user->id)
                    ->first();
            
            if ($lida == null){
                $this->id_notificacao = true;
                $this->qt_notificacoes++;
                $this->notificacoes[] = $notificacao;
                if ($this->qt_notificacoes >= $this::NUMERO_NOTIFICACOES){
                    break;
                }
            }
        }
       
        
        return $this->id_notificacao;
    }
}
