<?php

namespace App\Funcoes;

use App\Models\NotificacaoAlbum;

class VerificaNotificacoesAlbum
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
    
    public function verificar($id_user){
        
        $notificacoes = NotificacaoAlbum::where('id_user',$id_user)
                        ->where('id_lido',false)
                        ->orderBy('updated_at')->get();
            
        foreach($notificacoes as $notificacao){
            
            $this->id_notificacao = true;
            $this->qt_notificacoes++;
            $this->notificacoes[] = $notificacao;
            if ($this->qt_notificacoes >= $this::NUMERO_NOTIFICACOES){
               break;
            }            
        }
               
        return $this->id_notificacao;
    }
}
