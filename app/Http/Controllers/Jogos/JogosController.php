<?php

namespace App\Http\Controllers\Jogos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Selecao;
use App\Models\Estadio;
use App\Models\TipoRanking;
use App\Models\Jogo;
use Carbon\Carbon;
use App\Models\StatusJogo;
use App\Models\StatusRanking;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LogadoController;
use App\Models\Perfil;
use Illuminate\Support\Facades\Redirect;
use App\Funcoes\HandicapJogo;
use App\Events\ResultadoAtualizadoEvent;
use App\Models\User;
use App\Models\Ranking;
use Telegram;
use App\Events\NovoJogoEvent;
use App\Funcoes\GeraReciboPalpites;
use App\Funcoes\PontuacaoUsuario;
use App\Models\Aposta;

class JogosController extends LogadoController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->middleware(function ($request, $next) {
            if ($this->usuario->cd_perfil != Perfil::PERFIL_ADMINISTRADOR &&
                $this->usuario->cd_perfil != Perfil::PERFIL_ADM_CONTEUDO){                
                Redirect::to('home?nao_autorizado')->send();
            }
            
            return $next($request);
        });
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function telaIncluir()
    {        
        $tb_selecoes[0] = "Selecione uma Seleção";
        $selecoes = Selecao::where('id','>',0)->orderBy('ds_nome', 'asc')->get();
        foreach($selecoes as $selecao){
            $tb_selecoes[$selecao->id] = $selecao->ds_nome;
        }
        
        $tb_estadios[0] = "Selecione um Estádio";
        $estadios = Estadio::where('id','>',0)->orderBy('ds_nome', 'asc')->get();
        foreach($estadios as $estadio){
            $tb_estadios[$estadio->id] = $estadio->ds_nome;
        }
        
        $tb_tipos_ranking[0] = "Selecione o tipo do Jogo";
        $tipos_ranking = TipoRanking::where('tp_fase',TipoRanking::TIPO_FASE_SIMPLES)
                         ->where('cd_status',StatusRanking::ABERTO)
                         ->orderBy('ds_nome', 'asc')
                         ->get();
        foreach($tipos_ranking as $tipo_ranking){            
            $tb_tipos_ranking[$tipo_ranking->id] = $tipo_ranking->ds_nome;
        }
        
        view()->share('tb_selecoes', $tb_selecoes);
        view()->share('tb_estadios', $tb_estadios);
        view()->share('tb_tipos_ranking', $tb_tipos_ranking);
        
        return view('jogos.incluir');
    }
    
    public function incluir(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_selecao1' => 'required',
            'id_selecao2' => 'required',            
            'desc1' => 'required_if:id_descricao,true',
            'desc2' => 'required_if:id_descricao,true',
            'dt_jogo' => 'required|date_format:d/m/Y',            
            'hr_jogo' => 'required|date_format:H:i',
            'id_estadio' => 'required|exists:estadios,id',
            'id_ranking' => 'required|exists:tipos_rankings,id',
        ]);
        
        if ($validator->fails()) {
            return redirect('jogos/telaIncluir')
            ->withErrors($validator)
            ->withInput();
        }
        
        $id_notificacao = false;
        if ($request->has('id_notificacao')){
            $id_notificacao = $request->id_notificacao;
        }
        
        $id_penal = false;
        if ($request->has('id_penal')){
        	if ($request->id_penal){
            	$id_penal = true;
        	}
        }
        
        $dt_jogo = Carbon::createFromFormat('d/m/Y',$request->dt_jogo)->format('Y-m-d');
        $hr_jogo = $request->hr_jogo;
                
        $tipoRanking = TipoRanking::where('id',$request->id_ranking)->first();
        
        $handicap = new HandicapJogo($tipoRanking->id_handicap_casa);
        $handicap->calcular($request->id_selecao1, $request->id_selecao2);
                
        $jogo = new Jogo();
        $jogo->id_selecao1 = $request->id_selecao1;
        $jogo->id_selecao2 = $request->id_selecao2;
        $jogo->dt_jogo = $dt_jogo;
        $jogo->hr_jogo = $hr_jogo;
        $jogo->id_estadio = $request->id_estadio;
        $jogo->cd_status = StatusJogo::JOGO_PROGRAMADO;
        $jogo->cd_ranking = $request->id_ranking;
        
        if ($request->id_descricao == true){
            $jogo->ds_selecao1 = $request->desc1;
            $jogo->ds_selecao2 = $request->desc2;
        }
        else {
            $jogo->ds_selecao1 = '';
            $jogo->ds_selecao2 = '';
        }
        $jogo->qt_gols_selecao1 = 0;
        $jogo->qt_gols_selecao2 = 0;
        $jogo->id_vencedor = 0;
        $jogo->qt_gols_penal_selecao1 = 0;
        $jogo->qt_gols_penal_selecao2 = 0;
        $jogo->nr_pontos_handcap1 = $handicap->nr_pontos_handcap1;
        $jogo->nr_pontos_handcapX = $handicap->nr_pontos_handcapX;
        $jogo->nr_pontos_handcap2 = $handicap->nr_pontos_handcap2;
        $jogo->id_penal = $id_penal;
        
        $jogo->save();
        
        event(new NovoJogoEvent($jogo, $id_notificacao));
        
        return redirect('jogos/telaIncluir')->with('sucesso', 'Jogo Incluído com Sucesso!');
    }
    
    public function telaConsultarLista()
    {  
        $jogos = Jogo::where('id','>',0)
                    ->with('selecao1')
                    ->with('selecao2')
                    ->with('estadio')
                    ->with('statusJogo')
                    ->with('selecao1.grupo')
                    ->orderBy('dt_jogo', 'asc')
                    ->orderBy('hr_jogo', 'asc')
                    ->get();
        
        view()->share('jogos', $jogos);
        
        return view('jogos.telaConsultaLista');
    }
    
    public function telaManutencaoLista()
    {  
        $jogos = Jogo::where('id','>',0)
        ->with('selecao1')
        ->with('selecao2')
        ->with('estadio')
        ->with('statusJogo')
        ->orderBy('dt_jogo', 'asc')
        ->orderBy('hr_jogo', 'asc')
        ->get();
        
        view()->share('jogos', $jogos);
        
        return view('jogos.telaManutencaoLista');
    }
    
    public function telaAlterar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:jogos,id'
        ]);
        
        if ($validator->fails()) {
            return redirect('jogos/telaManutencaoLista')
            ->withErrors($validator)
            ->withInput();
        }
        
        $jogo = Jogo::where('id',$request->id)->first();
        
        $tb_selecoes[0] = "Selecione uma Seleção";
        $selecoes = Selecao::where('id','>',0)->orderBy('ds_nome', 'asc')->get();
        foreach($selecoes as $selecao){
            $tb_selecoes[$selecao->id] = $selecao->ds_nome;
        }
        
        $tb_estadios[0] = "Selecione um Estádio";
        $estadios = Estadio::where('id','>',0)->orderBy('ds_nome', 'asc')->get();
        foreach($estadios as $estadio){
            $tb_estadios[$estadio->id] = $estadio->ds_nome;
        }
        
        $tb_tipos_ranking[0] = "Selecione o tipo do Jogo";
        $tipos_ranking = TipoRanking::all();
        foreach($tipos_ranking as $tipo_ranking){
            $tb_tipos_ranking[$tipo_ranking->id] = $tipo_ranking->ds_nome;
        }
        
        view()->share('jogo', $jogo);
        view()->share('tb_selecoes', $tb_selecoes);
        view()->share('tb_estadios', $tb_estadios);
        view()->share('tb_tipos_ranking', $tb_tipos_ranking);
        
        return view('jogos.alterar');
    }
    
    public function Alterar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_jogo' => 'required|exists:jogos,id',
            'id_selecao1' => 'required',
            'id_selecao2' => 'required',
            'desc1' => 'required_if:id_descricao,true',
            'desc2' => 'required_if:id_descricao,true',
            'dt_jogo' => 'required|date_format:d/m/Y',
            'hr_jogo' => 'required|date_format:H:i',
            'id_estadio' => 'required|exists:estadios,id',
            'id_ranking' => 'required|exists:tipos_rankings,id'
        ]);
        
        if ($validator->fails()) {
            return redirect('jogos/telaAlterar?id='.$request->id_jogo)
            ->withErrors($validator)
            ->withInput();
        }
        
        $dt_jogo = Carbon::createFromFormat('d/m/Y',$request->dt_jogo)->format('Y-m-d');
       
        $jogo = Jogo::where('id', $request->id_jogo)->first();
        $jogo->id_selecao1 = $request->id_selecao1;
        $jogo->id_selecao2 = $request->id_selecao2;
        $jogo->dt_jogo = $dt_jogo;
        $jogo->hr_jogo = $request->hr_jogo;
        $jogo->id_estadio = $request->id_estadio;
        $jogo->cd_status = StatusJogo::JOGO_PROGRAMADO;
        $jogo->cd_ranking = $request->id_ranking;
        if ($request->id_descricao == true){
            $jogo->ds_selecao1 = $request->desc1;
            $jogo->ds_selecao2 = $request->desc2;
        }
        else {
            $jogo->ds_selecao1 = '';
            $jogo->ds_selecao2 = '';
        }
        
        $jogo->save();
        
        return redirect('jogos/telaManutencaoLista')->with('sucesso', 'Jogo Alterado com Sucesso!');
    }
    
    public function telaExcluir(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:jogos,id'
        ]);
        
        if ($validator->fails()) {
            return redirect('jogos/telaManutencaoLista')
            ->withErrors($validator)
            ->withInput();
        }
        
        $jogo = Jogo::where('id',$request->id)->first();
        
        view()->share('jogo', $jogo);
        
        return view('jogos.excluir');
    }
    
    public function Excluir(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_jogo' => 'required|exists:jogos,id'
        ]);
        
        if ($validator->fails()) {
            return redirect('jogos/telaExcluir?id='.$request->id_jogo)
            ->withErrors($validator)
            ->withInput();
        }
        
        $jogo = Jogo::where('id', $request->id_jogo)->first();               
        $jogo->delete();
        
        return redirect('jogos/telaManutencaoLista')->with('sucesso', 'Jogo Excluído com Sucesso!');
    }
    
    public function telaDetalhe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:jogos,id'
        ]);
        
        if ($validator->fails()) {
            return redirect('jogos/telaManutencaoLista')
            ->withErrors($validator)
            ->withInput();
        }
        
        $jogo = Jogo::where('id',$request->id)->first();
        
        view()->share('jogo', $jogo);
        
        return view('jogos.detalhe');
    }
    
    public function telaResultados()
    {   
        $jogos = Jogo::with('statusJogo')
                 ->with('tipoRanking.statusRanking')
                 ->with('estadio')
                 ->with('selecao1')
                 ->with('selecao2')
                 ->whereHas('tipoRanking.statusRanking',function ($q) {
                     $q->where('id',StatusRanking::ABERTO);
                 })
                 ->orderBy('dt_jogo', 'asc')
                 ->orderBy('hr_jogo', 'asc')
                 ->get();
         $ds_ids = "";
         foreach($jogos as $jogo){
             if ($ds_ids != ""){
                 $ds_ids .= "; ";
             }
             $ds_ids .= $jogo->id;     
         }
        
        view()->share('jogos', $jogos);
        view()->share('ds_ids', $ds_ids);
        
        return view('jogos.resultados');
    }
    
    public function resultados(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'ds_ids' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect('jogos/telaResultados')
            ->withErrors($validator)
            ->withInput();
        }
        
        DB::beginTransaction();
        
        $tb_ids = explode(';', $request->ds_ids);
        foreach($tb_ids as $id){
            $id_aux = trim($id);
            if ( $request->exists('placar1_'.$id_aux) || 
                 $request->exists('placar2_'.$id_aux)){
                
                if ($request->{'placar1_'.$id_aux} !== "" && 
                    $request->{'placar2_'.$id_aux} === ""){
                    $validator->errors()->add('placar2_'.$id_aux,'Placar 2 do Jogo '.$id_aux.' não informado!');
                    return redirect('jogos/telaResultados')
                    ->withErrors($validator)
                    ->withInput();
                }
                else if ($request->{'placar2_'.$id_aux} !== "" &&
                         $request->{'placar1_'.$id_aux} === ""){
                    $validator->errors()->add('placar1_'.$id_aux, 'Placar 1 do Jogo '.$id_aux.' não informado!');
                    return redirect('jogos/telaResultados')
                    ->withErrors($validator)
                    ->withInput();
                }
            }
            
            if ($request->{'placar1_'.$id_aux} != "" && $request->{'placar2_'.$id_aux} != ""){
                $jogo = Jogo::where('id',trim($id))->first();
                $jogo->qt_gols_selecao1 = $request->{'placar1_'.$id_aux};
                $jogo->qt_gols_selecao2 = $request->{'placar2_'.$id_aux};
                $jogo->cd_status = StatusJogo::JOGO_FINALIZADO;
                if ($jogo->id_penal){
                	if ($request->{'id_penal_'.$id_aux} > 0){
                		$jogo->id_vencedor = $request->{'id_penal_'.$id_aux};
                	}
                }
                $jogo->save();
            }
        }
        
        DB::commit();
                
        event(new ResultadoAtualizadoEvent());
        
        return redirect('jogos/telaResultados')->with('sucesso', 'Resultados Atualizados com Sucesso!');
    }
    
    public function recalcularHandcap(Request $request)
    {   
        $jogos = Jogo::where('cd_status', StatusJogo::JOGO_PROGRAMADO)
                 ->with('tipoRanking')
                 ->get();
        foreach($jogos as $jogo){
            $handicap = new HandicapJogo($jogo->tipoRanking->id_handicap_casa);
            $handicap->calcular($jogo->id_selecao1, $jogo->id_selecao2);
            
            $jogo->nr_pontos_handcap1 = $handicap->nr_pontos_handcap1;
            $jogo->nr_pontos_handcapX = $handicap->nr_pontos_handcapX;
            $jogo->nr_pontos_handcap2 = $handicap->nr_pontos_handcap2;
            $jogo->save();
        }
        
        return redirect('jogos/telaManutencaoLista')->with('sucesso', 'Handcaps recalculados com sucesso!');
    }

    public function telaReciboPalpites()
    {  
        $jogos = Jogo::where('cd_status', StatusJogo::JOGO_APOSTA_ENCERRADA)
        ->with('selecao1')
        ->with('selecao2')
        ->with('estadio')
        ->with('statusJogo')
        ->orderBy('dt_jogo', 'asc')
        ->orderBy('hr_jogo', 'asc')
        ->get();

        if (count($jogos) == 0){
            return redirect('home')->with('erro', 'Nenhum jogo com aposta encerrada!');
        }
        
        foreach($jogos as $jogo){
            $tb_jogos[] = $jogo->id;
        }

        if (isset($tb_jogos)){            
        	$jogosTrava = Jogo::whereIn('id',$tb_jogos)
            ->with('selecao1')
            ->with('selecao2')
            ->get();
            if (count($jogosTrava) > 0){
                foreach($jogosTrava as $jogoTrava){
                    $usersTrava = User::all();
                    foreach($usersTrava as $userTrava){
                        $aposta = Aposta::where('id_jogo',$jogoTrava->id)
                        ->where('id_user',$userTrava->id)
                        ->first();
                        if ($aposta == null){
                            $aposta10 = new Aposta();
                            $aposta10->id_jogo = $jogoTrava->id;
                            $aposta10->id_user = $userTrava->id;
                            $aposta10->qt_gols_selecao1 = 10;
                            $aposta10->qt_gols_selecao2 = 10;
                            $aposta10->id_selecao_penal = 0;
                            $aposta10->save();                            
                        }
                    }
                }
            }            
        }

        foreach($tb_jogos as $id_jogo){
            
            $jogo = Jogo::where('id',$id_jogo)
            ->with('selecao1')
            ->with('selecao2')
            ->first();
            
            $apostas = Aposta::where('id_jogo',$id_jogo)
            ->with('usuario')
            ->with('jogo')
            ->get()
            ->sortBy('usuario.name');
            $tb_apostas = array();
            foreach($apostas as $aposta){                
                $pontuacao = new PontuacaoUsuario();
                $pontuacao->calcularProgramadoJogo($aposta->id);
                
                $tb_apostas[] = array('aposta'=>$aposta,
                                      'pontuacao'=>$pontuacao
                                      );
            }
            
            $tb_saida[] = array('id_jogo'=>$id_jogo,
                'jogo'=>$jogo,
                'tb_apostas'=>$tb_apostas
            );
        }
        
        $recibo = new GeraReciboPalpites($tb_saida);
        $recibo->gerar();
        $recibo->pdf->save($recibo->ds_arquivo);    
        return response()->download($recibo->ds_arquivo, 'recibo.pdf', [], 'inline');
    }
}
