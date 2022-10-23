<?php

namespace App\Funcoes;

use Storage;

class VerificaAvatar
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    
    public static function verificar($id_user){
        
        $id_avatar_participante = false;
        
        if (Storage::disk('local')->exists('avatars/'.$id_user)){
            $id_avatar_participante = true;
        }
        
        return $id_avatar_participante;
    }
}
