<?php

namespace App\Funcoes;

use App\Models\JogadorUsuario;
use App\Models\TransacaoFigurinha;

class ValidaTransacao 
{
    
    public $id_user;
    public $id_jogador;
    public $ds_mensagem;
    public $qt_figurinhas;
    public $qt_transacoes;
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($id_user, $id_jogador)    
    {   
        $this->id_user = $id_user;
        $this->id_jogador = $id_jogador;
    }
    
    public function validar(){
                            
        $figurinhas = JogadorUsuario::where('id_jogador',$this->id_jogador)
        ->where('id_user',$this->id_user)
        ->get();
        
        $this->qt_figurinhas = count($figurinhas);
        if ($this->qt_figurinhas == 0){
            $this->ds_mensagem = 'Você não possui essa figurinha. Você não pode trocá-la!';
            return false;
        }
        
        $transacoes = TransacaoFigurinha::where('id_user',$this->id_user)
        ->where('id_jogador',$this->id_jogador)
        ->where('cd_status',TransacaoFigurinha::STATUS_ABERTA)
        ->get();
        
        $this->qt_transacoes = count($transacoes);        
        if ($this->qt_transacoes > 0){
            $this->ds_mensagem = 'Você já possui transações para essa figurinha!';
            return false;
        }
        
        return true;
    }
}
