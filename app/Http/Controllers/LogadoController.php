<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Funcoes\Tarefas;
use App\Funcoes\VerificaNotificacoes;
use App\Funcoes\VerificaMensagens;
use App\Funcoes\VerificaMensagensMural;
use App\Funcoes\VerificaNotificacoesAlbum;
use App\Models\Pool;
use App\Models\PoolVoto;
use App\Models\PoolValor;

class LogadoController extends Controller
{
    protected $usuario;
    protected $id_tarefas;
    protected $tarefas;
    protected $id_notificacoes;
    protected $notificacoes;
    protected $qt_notificacoes;
    protected $id_notificacoes_album;
    protected $notificacoesAlbum;
    protected $qt_notificacoes_album;
    protected $id_mensagens;
    protected $mensagens;
    protected $qt_mensagens;
    protected $id_msg_mural;
    protected $mensagens_mural;
        
    public function __construct(){
        
        $this->middleware('auth');
        
        $this->middleware(function ($request, $next) {
            $this->usuario = Auth::user();
            
            if (Storage::disk('local')->exists('avatars/'.$this->usuario->id)){                
                $img_avatar = Storage::disk('local')->get('avatars/'.$this->usuario->id);
                view()->share('id_avatar','S');
                view()->share('img_avatar', 'data:image/png;base64,'.base64_encode($img_avatar));
            }
            else {
                view()->share('id_avatar','N');
            }
            
            $this->id_tarefas = false;
            
            $tarefas = new Tarefas();
            if ($tarefas->verificar($this->usuario)){
            	$this->id_tarefas = true;
            	$this->tarefas = $tarefas;
            	view()->share('tarefas',$tarefas);
            }
            
            view()->share('id_tarefas',$this->id_tarefas);
            
            $this->id_notificacoes = false;
            $this->qt_notificacoes = 0;
            
            $notificacoes = new VerificaNotificacoes();
            if ($notificacoes->verificar($this->usuario)){
                $this->id_notificacoes = true;
                $this->notificacoes = $notificacoes->notificacoes;
                $this->qt_notificacoes = $notificacoes->qt_notificacoes;
                view()->share('notificacoes',$this->notificacoes);
            }
            
            view()->share('id_notificacoes',$this->id_notificacoes);
            view()->share('qt_notificacoes',$this->qt_notificacoes);
            
            $this->id_notificacoes_album = false;
            $this->qt_notificacoes_album = 0;
            
            $notificacoesAlbum = new VerificaNotificacoesAlbum();
            if ($notificacoesAlbum->verificar($this->usuario->id)){
                $this->id_notificacoes_album = true;
                $this->notificacoesAlbum = $notificacoesAlbum->notificacoes;
                $this->qt_notificacoes_album = $notificacoesAlbum->qt_notificacoes;
                view()->share('notificacoesAlbum',$this->notificacoesAlbum);
            }
            
            view()->share('id_notificacoes_album',$this->id_notificacoes_album);
            view()->share('qt_notificacoes_album',$this->qt_notificacoes_album);
            
            $this->id_mensagens = false;
            $this->qt_mensagens = 0;
            
            $mensagens = new VerificaMensagens();
            if ($mensagens->verificar($this->usuario)){
                $this->id_mensagens = true;
                $this->mensagens = $mensagens->mensagens;
                $this->qt_mensagens = $mensagens->qt_mensagens;
                view()->share('mensagens',$this->mensagens);
            }
            
            view()->share('id_mensagens',$this->id_mensagens);
            view()->share('qt_mensagens',$this->qt_mensagens);
            
            $this->id_msg_mural = false;
            $mural = new VerificaMensagensMural();
            if ($mural->verificar($this->usuario)){
                $this->id_msg_mural = true;
                $this->mensagens_mural = $mural->mensagens;
                view()->share('mensagens_mural',$this->mensagens_mural);
            }
            
            view()->share('id_msg_mural',$this->id_msg_mural);
            
            return $next($request);
        });
    }
}
