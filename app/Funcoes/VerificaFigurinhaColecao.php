<?php

namespace App\Funcoes;

use App\Models\Jogador;
use App\Models\JogadorUsuario;
use App\Models\User;

class VerificaFigurinhaColecao
{
    public static function verificar(User $user, Jogador $jogador){
        
        $jogadorAux = JogadorUsuario::where('id_user',$user->id)
                      ->where('id_jogador',$jogador->id)
                      ->first();
        
        if ($jogadorAux == null){
            return false;  
        }
        else{
            return true;
        }        
    }
}
