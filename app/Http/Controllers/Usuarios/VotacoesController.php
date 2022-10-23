<?php

namespace App\Http\Controllers\Usuarios;

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
use App\Models\HistoricoPontoXP;
use App\Models\Mural;
use App\Models\AvisoAposta;
use App\Mail\EmailRecibo;
use Illuminate\Support\Facades\Mail;
use App\Models\TipoRanking;
use App\Models\StatusRanking;
use App\Models\Premio;
use App\Models\Ranking;
use Illuminate\Support\Facades\Storage;
use App\Events\PremioPagoEvent;
use Illuminate\Support\Facades\DB;
use App\Models\Pool;
use App\Models\PoolValor;
use App\Models\PoolVoto;

class VotacoesController extends LogadoController
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
    
    public function telaListaVotacoes(){
        $votacoes = Pool::where('id','>',0)->get();
        
        if (count($votacoes) == 0){
            return redirect('home')->with('erro', 'Não Ná Nenhuma Votação Cadastrada!');
        }
        
        $tb_votacoes = array();
        foreach($votacoes as $votacao){
            $votos = PoolVoto::where('id_pool',$votacao->id)->get();
            
            $tb_votacoes[] = array('votacao' => $votacao, 
                                   'votos' => $votos 
                                  );
        }
        
        view()->share('tb_votacoes',$tb_votacoes);
        
        return view('votacoes.telaListaVotacoes');
    }
    
    public function detalharVotacao(Request $request){
        
        $validator = Validator::make($request->all(), [
            'id_votacao' => 'required|exists:pools,id',
        ]);
        
        if ($validator->fails()) {
            return redirect('usuarios/telaListaVotacoes')
            ->withErrors($validator)
            ->withInput();
        }
        
        $votacao = Pool::where('id',$request->id_votacao)->first();        
        view()->share('votacao',$votacao);
        
        $tb_cores[1] = "#68BC31";
        $tb_cores[2] = "#2091CF";
        $tb_cores[3] = "#AF4E96";
        $tb_cores[4] = "#DA5430";
        $tb_cores[5] = "#FEE074";
        
        $valores = PoolValor::where('id_pool',$votacao->id)->get();
        $nr = 0;
        $total_votos = 0;
        $tb_valores = array();
        foreach($valores as $valor){
            $nr++;
            
            $votos = PoolVoto::where('id_pool',$valor->id_pool)
                     ->where('cd_valor',$valor->cd_valor)
                     ->get();
            $total_votos += count($votos);
            
            $tb_valores[] = array('nr' => $nr,
                                  'ds_cor' => $tb_cores[$nr],
                                  'ds_valor' => $valor->ds_valor,
                                  'qt_votos' => count($votos)
                                 );
        }
        view()->share('tb_valores',$tb_valores);
        view()->share('total_votos',$total_votos);
        
        return view('votacoes.detalharVotacao');
    }
}
