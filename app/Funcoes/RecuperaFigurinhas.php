<?php

namespace App\Funcoes;

use App\Models\JogadorUsuario;
use App\Models\Jogador;
use App\Models\User;

class RecuperaFigurinhas 
{
 
    public $usuario;
    public $tb_figurinhas;
    public $qt_tiradas;
    public $qt_repetidas;
    public $ds_mensagem;
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $usuario)    
    {   
        $this->usuario = $usuario;
    }
    
    public function recuperar(){
                            
        $figurinhas = JogadorUsuario::where('id_user',$this->usuario->id)
        ->orderBy('id_jogador')
        ->get();
        
        if (count($figurinhas) == 0){
            $this->ds_mensagem = 'Você ainda não possui nenhuma figurinha!';
            return false;
        }
        
        $tb_aux = array();
        foreach($figurinhas as $figurinha){
            if (isset($tb_aux[$figurinha->id_jogador])){
                $tb_aux[$figurinha->id_jogador]++;
            }
            else {
                $tb_aux[$figurinha->id_jogador] = 1;
            }
        }
        
        $this->qt_tiradas = 0;
        $this->qt_repetidas = 0;        
        $tb_figurinhas = array();
        foreach($tb_aux as $key=>$value)
        {
            $this->qt_tiradas++;            
            $jogador = Jogador::where('id',$key)
            ->with('selecao')
            ->first();
            
            $tb_figurinhas[] = array('id_jogador'=>$key,
                'qt_figurinhas'=>$value,
                'jogador'=>$jogador);
            
            if ($value > 1){
                $this->qt_repetidas++;
            }
        }
        
        $this->tb_figurinhas = $tb_figurinhas;
        
        return true;        
    }    
}
