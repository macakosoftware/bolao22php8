<?php

namespace App\Http\Controllers\Usuarios;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\LogadoController;
use App\Models\MensagemMural;
use Auth;

class MuralController extends LogadoController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    
    public function postar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ds_msg_mural' => 'required|min:3'
        ]);
        
        if ($validator->fails()) {
            return redirect('home')
            ->withErrors($validator)
            ->withInput();
        }
        
        $mural = new MensagemMural();                          
        $mural->id_user = Auth::user()->id;
        $mural->ds_mensagem = $request->ds_msg_mural;
        $mural->save();
        
        return redirect('home');
    }
}
