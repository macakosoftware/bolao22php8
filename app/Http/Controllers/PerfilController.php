<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Facades\Storage;
use App\Models\BadgeUser;

class PerfilController extends LogadoController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function telaPerfil()
    {   
        $usuario = Auth::user();
        
        view()->share('usuario', $usuario);
        
        return view('perfil');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function alterarPerfil(Request $request)
    {  
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'email' => 'required|email',
            'password' => 'required_if:id_alterar_senha,true|confirmed',
            'foto_perfil' => 'max:2048'
        ]);
        
        if ($validator->fails()) {
            return redirect('perfil')
            ->withErrors($validator)
            ->withInput();
        }
        
        $user = Auth::user();
        
        if ($request->has('foto_perfil')){
	        if ($request->file('foto_perfil')->isValid()){            
	            if ($request->file('foto_perfil')->getRealPath() != ''){
	                            
	                $img = Image::make($request->file('foto_perfil')->getRealPath());
	                
	                $img->resize(128, 128);
	                $img->encode('png');
	                
	                Storage::put(
	                    'avatars/'.$user->id,
	                    $img
	                    );
	            }
	        }
        }
        
        $user->name = $request->nome;
        $user->email = $request->email;
        if($request->id_alterar_senha){
        	$user->password = bcrypt($request->password);
        }
       	$user->save();
        
        return redirect('home')->with('sucesso', 'Perfil Atualizado com Sucesso!');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function telaTrofeus()
    {
        $usuario = Auth::user();
        
        $badges = BadgeUser::where('id_user',$usuario->id)
                  ->with('badge')
                  ->get();
        $qt_badges = count($badges);
        if ($qt_badges > 0){
            view()->share('badges',$badges);
        }
        
        view()->share('qt_badges',$qt_badges);
        view()->share('usuario', $usuario);
        
        return view('trofeus');
    }
}
