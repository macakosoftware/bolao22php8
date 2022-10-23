<?php

namespace App\Http\Controllers\Mensagens;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\LogadoController;
use Illuminate\Support\Facades\Validator;
use App\Models\Mensagem;
use Illuminate\Support\Facades\DB;
use App\Models\Destinatario;

class MensagensController extends LogadoController
{

    public const BOTAO_RESPONDER = "responder";
    public const BOTAO_APAGAR = "apagar";
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    public function telaNovaMensagem()
    {
        $usuarios = User::orderBy('name')->get();
        
        $tb_usuarios = array();
        foreach($usuarios as $usuario){
            if ($usuario->id != $this->usuario->id){
                $tb_usuarios[$usuario->id] = $usuario->name;
            }
        }
        
        view()->share('tb_usuarios',$tb_usuarios);
        
        return view('mensagens.telaNovaMensagem');
    }
    
    public function enviar(Request $request){
        
        $validator = Validator::make($request->all(), [
            'tb_destinatarios' => 'required',
            'ds_titulo' => 'required',
            'ds_mensagem' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect('mensagens/telaNovaMensagem')
            ->withErrors($validator)
            ->withInput();
        }
        
        if (count($request->tb_destinatarios) == 0){
            return redirect('mensagens/telaNovaMensagem')
            ->with('erro','Nenhum destinatário selecionado. Favor informar pelo menos um!')
            ->withInput();
        }
        
        DB::beginTransaction();
        
        $mensagem = new Mensagem();
        $mensagem->id_user_from = $this->usuario->id;
        $mensagem->ds_titulo = $request->ds_titulo;
        $mensagem->ds_mensagem = $request->ds_mensagem;
        $mensagem->id_mensagem_relacionada = 0;
        $mensagem->save();
        
        foreach($request->tb_destinatarios as $id_destinatario){
            $destinatario = new Destinatario();
            $destinatario->id_mensagem = $mensagem->id;
            $destinatario->id_user = $id_destinatario;
            $destinatario->id_lido = false;
            $destinatario->save();
        }
        
        DB::commit();
        
        return redirect('home')
        ->with('sucesso','Mensagem enviada com sucesso!');
    }
    
    public function telaVerMensagem(Request $request){
        
        $validator = Validator::make($request->all(), [
            'id_mensagem' => 'required|exists:mensagens,id',
        ]);
        
        if ($validator->fails()) {
            return redirect('home')
            ->withErrors($validator)
            ->withInput();
        }
        
        
        $mensagem = Mensagem::where('id',$request->id_mensagem)->first();
        
        $destinatario = Destinatario::where('id_user',$this->usuario->id)
                        ->where('id_mensagem',$request->id_mensagem)
                        ->first();
        $destinatario->id_lido = true;
        $destinatario->save();
        
        if ($mensagem->id_mensagem_relacionada > 0){
            $continua = true;
            $id_mensagem_relacionada = $mensagem->id_mensagem_relacionada;
            
            while($continua){
                $relacionada = Mensagem::where('id',$id_mensagem_relacionada)
                               ->orderBy('created_at')
                               ->first();
                $relacionadas[] = $relacionada;
                if ($relacionada->id_mensagem_relacionada > 0){
                    $id_mensagem_relacionada = $relacionada->id_mensagem_relacionada;                    
                }
                else {
                    $continua = false;
                }
            }
            
            view()->share('relacionadas',$relacionadas);
        }
        
        view()->share('mensagem',$mensagem);
        
        return view('mensagens.telaVerMensagem');
    }
    
    public function tratarMensagem(Request $request){
        
        $validator = Validator::make($request->all(), [
            'id_mensagem' => 'required|exists:mensagens,id',
            'submit' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect('mensagens/telaVerMensagem')
            ->withErrors($validator)
            ->withInput();
        }
        
        if ($request->submit == $this::BOTAO_RESPONDER){
            $mensagem = Mensagem::where('id',$request->id_mensagem)->first();
            
            $destinatario = Destinatario::where('id_mensagem',$request->id_mensagem)
                            ->where('id_user',$this->usuario->id)
                            ->first();
            $destinatario->id_lido = true;
            $destinatario->save();
            
            if ($mensagem->id_mensagem_relacionada > 0){
                $continua = true;
                $id_mensagem_relacionada = $mensagem->id_mensagem_relacionada;
                
                while($continua){
                    $relacionada = Mensagem::where('id',$id_mensagem_relacionada)
                    ->orderBy('created_at')
                    ->first();
                    $relacionadas[] = $relacionada;
                    if ($relacionada->id_mensagem_relacionada > 0){
                        $id_mensagem_relacionada = $relacionada->id_mensagem_relacionada;
                    }
                    else {
                        $continua = false;
                    }
                }
                
                view()->share('relacionadas',$relacionadas);
            }
            
            view()->share('mensagem',$mensagem);
            return view('mensagens.telaResponderMensagem');
            
        }
        else if ($request->submit == $this::BOTAO_APAGAR){
            $destinatario = Destinatario::where('id_mensagem',$request->id_mensagem)->first();
            $destinatario->delete();
            
            return redirect('home')
            ->with('sucesso','Mensagem deletada com sucesso!');
        }
    }
    
    public function enviarResposta(Request $request){
        
        $validator = Validator::make($request->all(), [
            'id_mensagem' => 'required|exists:mensagens,id',            
        ]);
        
        if ($validator->fails()) {
            return redirect('mensagens/telaVerMensagem')
            ->withErrors($validator)
            ->withInput();
        }
        
        $original = Mensagem::where('id',$request->id_mensagem)->first();
        
        $mensagem = new Mensagem();
        $mensagem->id_user_from = $this->usuario->id;
        $mensagem->ds_titulo = 'RE:'.$original->ds_titulo;
        $mensagem->ds_mensagem = $request->ds_mensagem;
        $mensagem->id_mensagem_relacionada = $request->id_mensagem;
        $mensagem->save();
        
        $destinatario = new Destinatario();
        $destinatario->id_mensagem = $mensagem->id;
        $destinatario->id_user = $original->id_user_from;
        $destinatario->id_lido = false;
        $destinatario->save();
        
        $destinatarios = Destinatario::where('id_mensagem',$request->id_mensagem)->get();
        foreach($destinatarios as $dest){
            if ($dest->id_user != $this->usuario->id){
                $destinatario = new Destinatario();
                $destinatario->id_mensagem = $mensagem->id;
                $destinatario->id_user = $dest->id_user;
                $destinatario->id_lido = false;
                $destinatario->save();
            }
        }
        
        return redirect('home')
        ->with('sucesso','Mensagem respondida com sucesso!');
    }
    
    public function telaConsultarMensagens(){
        $msgsAux = Destinatario::where('id_user',$this->usuario->id)               
                ->orderBy('created_at','DESC')
                ->with('mensagem')
                ->get();
        
        $tb_relacionadas = array();
        foreach($msgsAux as $msgAux){
            if (!in_array($msgAux->mensagem->id,$tb_relacionadas)){
                $msgs[] = $msgAux;
            }
            
            if ($msgAux->mensagem->id_mensagem_relacionada > 0){
                $continua = true;
                $id_mensagem_relacionada = $msgAux->mensagem->id_mensagem_relacionada;
                
                while($continua){
                    $relacionada = Mensagem::where('id',$id_mensagem_relacionada)
                    ->orderBy('created_at')
                    ->first();
                    $tb_relacionadas[] = $relacionada->id;
                    if ($relacionada->id_mensagem_relacionada > 0){
                        $id_mensagem_relacionada = $relacionada->id_mensagem_relacionada;
                    }
                    else {
                        $continua = false;
                    }
                }
            }
        }
                
        if (!isset($msgs)){
            return redirect('home')
            ->with('erro','Você ainda não tem nenhuma mensagem!');
        }
        if (count($msgs) == 0){
            return redirect('home')
            ->with('erro','Você ainda não tem nenhuma mensagem!');
        }
        
        view()->share('msgs',$msgs);
        
        return view('mensagens.telaConsultarMensagens');
    }
}
