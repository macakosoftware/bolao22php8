<?php

namespace App\Http\Controllers\Notificacoes;

use Illuminate\Http\Request;
use App\Models\Perfil;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Pagamento;
use App\Http\Controllers\LogadoController;
use Illuminate\Support\Facades\Redirect;
use App\Events\UsuarioIncluidoEvent;
use App\Models\FormaPagamento;
use App\Models\MovimentoPagamento;
use App\Models\HistCreditoUsuario;
use App\Models\CreditoUsuario;
use App\Funcoes\GeraRecibo;
use App\Events\JoiaPagaEvent;
use App\Models\Notificacao;
use App\Events\NotificacaoSimplesEvent;
use App\Models\NotificacaoLida;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificacaoAlbum;

class NotificacoesController extends LogadoController
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
    
    public function consultarListaNotificacoes()
    {
        $user = Auth::user();
        
        $notificacoes = Notificacao::where('id','>',0)
                        ->orderBy('updated_at', 'DESC')
                        ->get();
        
        foreach($notificacoes as $notificacao){
            $lida = NotificacaoLida::where('id_notificacao',$notificacao->id)
                    ->where('id_user',$user->id)
                    ->first();
            if ($lida == null){
                $id_lido = false;
            }
            else {
                $id_lido = true;
            }
            
            $tb_notificacoes[] = array('id'=>$notificacao->id,
                                       'ds_texto'=>$notificacao->ds_texto,
                                       'dt_hr_notificacao'=>$notificacao->updated_at,
                                       'id_lido'=>$id_lido,
                                       'ds_cor'=>$notificacao->ds_cor,
                                       'ds_icon'=>$notificacao->ds_icon,
                                       'tp_registro'=>'N',
                                       'tp_notificacao'=>$notificacao->tp_notificacao
                                       );
        }
        
        $notificacoes = NotificacaoAlbum::where('id','>',0)
                        ->orderBy('updated_at', 'DESC')
                        ->get();
        
        $tb_notificacoes = array();
        foreach($notificacoes as $notificacao){
            $tb_notificacoes[] = array('id'=>$notificacao->id,
                                       'ds_texto'=>$notificacao->ds_observacao,
                                       'dt_hr_notificacao'=>$notificacao->updated_at,
                                       'id_lido'=>$notificacao->id_lido,
                                       'ds_cor'=>'btn-primary',
                                       'ds_icon'=>'fa-check',
                                       'tp_registro'=>'A',
                                       'tp_notificacao'=>$notificacao->tp_notificacao
                                       );
        }
        
        if (count($tb_notificacoes) == 0){
            return redirect('home')->with('erro', 'Ainda hão há nenhuma notificação cadastrada!');
        }
        
        view()->share('tb_notificacoes',$tb_notificacoes);
        
        return view('notificacoes.consultarNotificacoes');
    }
    
    public function telaConsultaNotSimples(Request $request){

        $validator = Validator::make($request->all(), [
            'id_notificacao' => 'required|exists:notificacoes,id'
        ]);
        
        if ($validator->fails()) {
            return redirect('notificacoes/consultarListaNotificacoes')
            ->withErrors($validator)
            ->withInput();
        }
        
        $notificacao = Notificacao::where('id',$request->id_notificacao)->first();
        
        $user = Auth::user();
        
        $lida = NotificacaoLida::where('id_notificacao',$notificacao->id)
                ->where('id_user',$user->id)
                ->first();
        if ($lida == null){
            $lida = new NotificacaoLida();
            $lida->id_notificacao = $notificacao->id;
            $lida->id_user = $user->id;
            $lida->save();
        }
        
        view()->share('notificacao',$notificacao);
        
        return view('notificacoes.telaConsultaNotSimples');
    }    
}
