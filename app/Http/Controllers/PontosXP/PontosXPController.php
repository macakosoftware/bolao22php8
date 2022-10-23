<?php

namespace App\Http\Controllers\PontosXP;

use App\Models\HistoricoPontoXP;
use App\Http\Controllers\LogadoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\User;

class PontosXPController extends LogadoController
{
    protected const IMAGEM_BROTHETA = "images/brotheta.png";
    
    public const DIR_FONTES ='/assets/fonts/';
        
    public const FONTE_BUCKS ='10_Bucks.ttf';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    public function resumoUsuario()
    {
        $user = Auth::user();
        
        $hists = HistoricoPontoXP::where('id_user',$user->id)->get();
        
        view()->share('usuario',$user);
        view()->share('hists',$hists);
        
        return view('pontosXP.resumoUsuario');
    }    
    
    public function montaCedula(Request $request){
        
        $usuario = User::where('id',$request->id_usuario)->first();
        $ds_valor = number_format($usuario->qt_pontos_xp,2,',','');
        
        $image = Image::make(public_path($this::IMAGEM_BROTHETA));
        
        $image->text($ds_valor, 690, 200, function($font){
            $font->file(public_path($this::DIR_FONTES.$this::FONTE_BUCKS));
            $font->size(60);
            $font->color("#000000");
            $font->align('center');            
        });
       
        
        return $image->encode('png');
    }
}
