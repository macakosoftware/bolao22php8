<?php

namespace App\Http\Controllers\Apostas;

use App\Models\Aposta;
use App\Models\Jogo;
use App\Models\StatusJogo;
use App\Models\User;
use App\Funcoes\HandicapGol;
use App\Funcoes\PontuacaoUsuario;
use App\Http\Controllers\LogadoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Telegram;
use App\Funcoes\CalculaResultado;
use App\Models\TipoRanking;
use App\Models\FaseRanking;
use App\Models\Selecao;
use App\Events\ApostaAtualizadaEvent;

class ApostasController extends LogadoController
{
    const COD_COMBO_STATUS_TODOS = 0;
    const COD_COMBO_STATUS_ABERTOS = 1;
    const COD_COMBO_STATUS_FINALIZADOS = 2;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();        
    }
    
    public function telaEditar()
    {  
        $jogos = Jogo::where('id','>',0)
        ->with('selecao1')
        ->with('selecao2')
        ->with('estadio')
        ->with('selecao1.grupo')
        ->with('selecao1.handcap')
        ->with('selecao2.handcap')
        ->with('statusJogo')
        ->with('tipoRanking')
        ->where('cd_status',StatusJogo::JOGO_PROGRAMADO)
        ->orderBy('dt_jogo')
        ->orderBy('hr_jogo')
        ->get();
        
        $ds_ids = "";       
        $tb_jogos = array(); 
        foreach($jogos as $jogo){ 
            if ($jogo->dt_jogo > date('Y-m-d') || 
               ($jogo->dt_jogo == date('Y-m-d') && $jogo->hr_jogo > date('H:i:s'))){              
              if ($ds_ids != ""){
                $ds_ids .= "; ";
              }
              $ds_ids .= $jogo->id;
                
              $aposta = Aposta::where('id_jogo', $jogo->id)
                          ->where('id_user', $this->usuario->id)
                          ->first();
              $qt_aposta_selecao1 = "";
              $qt_aposta_selecao2 = "";
              $id_selecao_penal = 0;
              if ($aposta != null){
                $qt_aposta_selecao1 = $aposta->qt_gols_selecao1;  
                $qt_aposta_selecao2 = $aposta->qt_gols_selecao2;  
                if ($aposta->id_selecao_penal > 0){
                	$id_selecao_penal = $aposta->id_selecao_penal;
                }
              }
              
              $handicapGol = new HandicapGol($jogo);          
              $handicapGol->calcular($jogo->id_selecao1, $jogo->id_selecao2);
              
              if (isset($tb_times)){
              	unset($tb_times);
              }
              $tb_times[$jogo->selecao1->id] = $jogo->selecao1->ds_nome;
              $tb_times[$jogo->selecao2->id] = $jogo->selecao2->ds_nome;
                                  
              $tb_jogos[] = array('dt_jogo'=>$jogo->dt_jogo,
                                  'hr_jogo'=>$jogo->hr_jogo,
                                  'ds_ranking' =>$jogo->tipoRanking->ds_nome,
                                  'cd_ranking' =>$jogo->cd_ranking,
                                  'ds_grupo' =>$jogo->selecao1->grupo->ds_grupo,
                                  'ds_icone1'=>$jogo->selecao1->ds_icone,
                                  'ds_icone2'=>$jogo->selecao2->ds_icone,
                                  'id_jogo'=>$jogo->id,
                                  'ds_nome_selecao1'=>$jogo->selecao1->ds_nome,
                                  'ds_nome_selecao2'=>$jogo->selecao2->ds_nome,
                                  'ds_estadio'=>$jogo->estadio->ds_nome,
                                  'qt_aposta_selecao1'=>$qt_aposta_selecao1,
                                  'qt_aposta_selecao2'=>$qt_aposta_selecao2,
                                  'nr_pontos_handcap1'=>$jogo->nr_pontos_handcap1,
                                  'nr_pontos_handcapX'=>$jogo->nr_pontos_handcapX,
                                  'nr_pontos_handcap2'=>$jogo->nr_pontos_handcap2,
                                  'placar1' => $handicapGol->tb_placar1, 
                                  'placar2' => $handicapGol->tb_placar2,
                                  'placarX' => $handicapGol->tb_placarX,
                                  'parcial1' => $handicapGol->tb_parcial1,
                                  'parcial2' => $handicapGol->tb_parcial2,
              		              'id_penal' => $jogo->id_penal,
              		              'tb_times' => $tb_times,
              		              'id_selecao_penal' => $id_selecao_penal,
                                  );
            }
        }
        
        view()->share('ds_ids', $ds_ids);
        view()->share('tb_jogos', $tb_jogos);
        
        return view('apostas.telaEditar');
    }
    
    public function editar(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'ds_ids' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect('jogos/telaEditar')
            ->withErrors($validator)
            ->withInput();
        }
        
        $tb_ids = explode(';', $request->ds_ids);
        foreach($tb_ids as $id){
        	if ($request->{'id_penal_'.trim($id)}){
        		$id_selecao_penal = $request->{'id_selecao_penal_'.trim($id)};
        	}
        	else {
        		$id_selecao_penal = 0;
        	}
            $tb_placar[] = array('id' => trim($id),
                'placar1' => $request->{'placar1_'.trim($id)},
                'placar2' => $request->{'placar2_'.trim($id)},
                'id_penal' => $request->{'id_penal_'.trim($id)},
                'id_selecao_penal' => $id_selecao_penal
            );
        }
        
        DB::beginTransaction();
        
        foreach($tb_placar as $placar){
                    
            if ($placar['placar1'] != "" &&
                $placar['placar2'] == ""){
                $validator->errors()->add('placar2_'.$placar['id'], 'Placar 2 do Jogo '.$placar['id'].' não informado!');
                return redirect('apostas/telaEditar')
                ->withErrors($validator)
                ->withInput();
            }
            else if ($placar['placar2'] != "" &&
                     $placar['placar1'] == ""){
                $validator->errors()->add('placar1_'.$placar['id'], 'Placar 1 do Jogo '.$placar['id'].' não informado!');
                return redirect('apostas/telaEditar')
                ->withErrors($validator)
                ->withInput();
            }
            
            if ($placar['placar1'] != "" && $placar['placar2'] != ""){
                $aposta = Aposta::where('id_jogo',$placar['id'])
                          ->where('id_user',$this->usuario->id)
                          ->first();
                if ($aposta == null){
                    $aposta = new Aposta();
                    $aposta->id_jogo = intval($placar['id']);
                    $aposta->qt_gols_selecao1 = $placar['placar1'];
                    $aposta->qt_gols_selecao2 = $placar['placar2'];
                    $aposta->id_user = $this->usuario->id;
                    if ($aposta->qt_gols_selecao1 == $aposta->qt_gols_selecao2){
                    	$aposta->id_selecao_penal = $placar['id_selecao_penal'];
                    }
                    else {
                    	$aposta->id_selecao_penal = 0;
                    }
                    $aposta->save();        
                }
                else {
                    $aposta->qt_gols_selecao1 = $placar['placar1'];
                    $aposta->qt_gols_selecao2 = $placar['placar2'];
                    if ($aposta->qt_gols_selecao1 == $aposta->qt_gols_selecao2){
                    	$aposta->id_selecao_penal = $placar['id_selecao_penal'];
                    }
                    else {
                    	$aposta->id_selecao_penal = 0;
                    }
                    $aposta->save();                    
                }
                $tb_apostas[] = $aposta->id;
            }
        }
        
        DB::commit();
        
        if (isset($tb_apostas)){
            event(new ApostaAtualizadaEvent($this->usuario, $tb_apostas));
        }
        
        return redirect('apostas/telaEditar')->with('sucesso', 'Apostas Atualizadas com Sucesso!');
    }

    public function telaMinhaConsultaLista(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cd_ranking' => 'required|exists:tipos_rankings,id',
            'cd_status' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect('home')
            ->withErrors($validator)
            ->withInput();
        }

        $tb_rankings = array();
        $tb_status = array();

        if ($request->cd_ranking == env('CLASSIFICACAO_GERAL','1')){
            $tiposRankings = TipoRanking::where('tp_fase',TipoRanking::TIPO_FASE_SIMPLES)
                     ->get();
            foreach($tiposRankings as $tipoRanking){
                $tb_rankings[] = $tipoRanking->id;    
            }            
        }
        else {
            $tipoRanking = TipoRanking::where('id',$request->cd_ranking)->first();
            if ($tipoRanking->tp_fase == TipoRanking::TIPO_FASE_COMPOSTO){
                $fases = FaseRanking::where('id_ranking_composto',$request->cd_ranking)
                         ->get();
                foreach($fases as $fase){
                    $tb_rankings[] = $fase->id_ranking_simples;    
                }
            }
            else {
                $tb_rankings[] = $request->cd_ranking;
            }
        }
        
        if ($request->cd_status == $this::COD_COMBO_STATUS_TODOS){
            $tb_status = [StatusJogo::JOGO_PROGRAMADO, StatusJogo::JOGO_FINALIZADO,
                StatusJogo::JOGO_PREVISTO, StatusJogo::JOGO_APOSTA_ENCERRADA];
        }
        else if ($request->cd_status == $this::COD_COMBO_STATUS_ABERTOS){
            $tb_status = [StatusJogo::JOGO_PROGRAMADO, StatusJogo::JOGO_APOSTA_ENCERRADA, 
                StatusJogo::JOGO_PREVISTO];
        }
        else if ($request->cd_status == $this::COD_COMBO_STATUS_FINALIZADOS){
            $tb_status[] = StatusJogo::JOGO_FINALIZADO;
        }
        
        $jogos = Jogo::where('id','>',0)
        ->whereIn('cd_ranking',$tb_rankings)
        ->whereIn('cd_status',$tb_status)
        ->with('selecao1')
        ->with('selecao2')
        ->with('estadio')
        ->with('selecao1.grupo')
        ->with('selecao1.handcap')
        ->with('selecao2.handcap')
        ->with('statusJogo')        
        ->orderBy('dt_jogo', 'asc')
        ->orderBy('hr_jogo', 'asc')
        ->get();
        
        
        foreach($jogos as $jogo){
            
            $pontuacao = new PontuacaoUsuario();
            
            $aposta = Aposta::where('id_jogo', $jogo->id)
            ->where('id_user', $this->usuario->id)
            ->first();
            $qt_aposta_selecao1 = "";
            $qt_aposta_selecao2 = "";
            
            $qt_pontos_resultado = "-";
            $qt_pontos_placar_cheio = "-";
            $qt_pontos_placar_parcial = "-";
            $qt_pontos_maximo = "-";
            
            $qt_jogo_selecao1 = "";
            $qt_jogo_selecao2 = "";
            $id_final_jogo = "";
            $id_final_aposta = "";
            
            $class_selecao1 = "";
            $class_selecao2 = "";
            $class_placar1 = "";
            $class_X = "";
            $class_placar2 = "";
            $class_penal = "";
            
            $id_mostra1 = false;
            $id_mostra2 = false;
            $id_mostra_penal = false;

            $ds_jogo_selecao_penal = "";
            
            if ($aposta != null){
                $qt_aposta_selecao1 = intval($aposta->qt_gols_selecao1);
                $qt_aposta_selecao2 = intval($aposta->qt_gols_selecao2);
                
                $id_selecao_penal = $aposta->id_selecao_penal;
                $ds_selecao_penal = '';
                $ds_icone_penal = '';
                if ($id_selecao_penal > 0){
                	$selecaoPenal = Selecao::where('id',$id_selecao_penal)->first();
                	if ($selecaoPenal != null){
                		$ds_selecao_penal = $selecaoPenal->ds_nome;
                		$ds_icone_penal = $selecaoPenal->ds_icone;
                	}
                }
                
                $pontuacao->calcularProgramadoJogo($aposta->id);
                $qt_pontos_resultado = $pontuacao->qt_pontos_resultado;
                $qt_pontos_placar_cheio = $pontuacao->qt_pontos_placar_cheio;
                if ($pontuacao->qt_pontos_placar_parcial1 > $pontuacao->qt_pontos_placar_parcial2){
                    $qt_pontos_placar_parcial = $pontuacao->qt_pontos_placar_parcial1;
                }
                else {
                    $qt_pontos_placar_parcial = $pontuacao->qt_pontos_placar_parcial2;
                }
                $qt_pontos_bonus = $pontuacao->qt_pontos_bonus;
                $qt_pontos_maximo = $pontuacao->qt_pontos_maximo;
                
                if ($aposta->qt_gols_selecao1 == $aposta->qt_gols_selecao2){
                    $id_final_aposta = "X";
                }
                else if ($aposta->qt_gols_selecao1 > $aposta->qt_gols_selecao2){
                    $id_final_aposta = "1";
                }
                else {
                    $id_final_aposta = "2";
                }
                
                if ($jogo->cd_status == StatusJogo::JOGO_FINALIZADO){
                    $calculo = new CalculaResultado();
                    $calculo->calcular($aposta->id);
                    
                    $qt_pontos_resultado = $calculo->qt_pontos_resultado;
                    $qt_pontos_placar_cheio = $calculo->qt_pontos_placar_cheio;
                    $qt_pontos_placar_parcial = $calculo->qt_pontos_placar_parcial;
                    $qt_pontos_maximo = $calculo->qt_pontos_total;
                    $qt_pontos_bonus = $calculo->qt_pontos_bonus;
                    
                    $qt_jogo_selecao1 = $jogo->qt_gols_selecao1;
                    $qt_jogo_selecao2 = $jogo->qt_gols_selecao2;
                    
                    if ($jogo->qt_gols_selecao1 == $jogo->qt_gols_selecao2){
                        $id_final_jogo = "X";
                    }
                    else if ($jogo->qt_gols_selecao1 > $jogo->qt_gols_selecao2){
                        $id_final_jogo = "1";
                    }
                    else {
                        $id_final_jogo = "2";
                    }
                    if ($id_final_jogo == $id_final_aposta){
                        if ($id_final_jogo == "1"){
                            $class_selecao1 = "green";
                        }
                        else if ($id_final_jogo == "2"){
                            $class_selecao2 = "green";
                        }
                        else {
                            $class_X = "green";
                        }
                        if ($jogo->qt_gols_selecao1 == $aposta->qt_gols_selecao1 &&
                            $jogo->qt_gols_selecao2 == $aposta->qt_gols_selecao2){
                                $class_placar1 = "green";
                                $class_X = "green";
                                $class_placar2 = "green";
                        }
                        else {
                            if ($jogo->qt_gols_selecao1 == $aposta->qt_gols_selecao1){
                                $class_placar1 = "green";
                                $id_mostra2 = true;
                            }
                            else if ($jogo->qt_gols_selecao2 == $aposta->qt_gols_selecao2){
                                $class_placar2 = "green";
                                $id_mostra1 = true;
                            }
                            else {
                                $id_mostra1 = true;
                                $id_mostra2 = true;
                            }
                        }
                    }
                    else {
                        $class_selecao1 = "red";
                        $class_selecao2 = "red";
                        $class_placar1 = "red";
                        $class_X = "red";
                        $class_placar2 = "red";
                        $id_mostra1 = true;
                        $id_mostra2 = true;
                    }
                    if ($jogo->id_penal){
                    	if ($id_final_jogo == "X"){
                    		if ($jogo->id_vencedor == $aposta->id_selecao_penal){
                    			$class_penal = "green";
                    		}
                    		else {
                    			$id_mostra_penal = true;
                    			$class_penal = "red";
                    			$selecaoPenal = Selecao::where('id',$jogo->id_vencedor)->first();
                    			$ds_jogo_selecao_penal = $selecaoPenal->ds_nome;
                    		}
                    	}
                    }
                }
                
                $tb_jogos[] = array('dt_jogo'=>$jogo->dt_jogo,
                    'hr_jogo'=>$jogo->hr_jogo,
                    'cd_status'=>$jogo->cd_status,
                    'ds_ranking' =>$jogo->tipoRanking->ds_nome,
                    'cd_ranking' =>$jogo->cd_ranking,
                    'ds_grupo' =>$jogo->selecao1->grupo->ds_grupo,
                    'ds_icone1'=>$jogo->selecao1->ds_icone,
                    'ds_icone2'=>$jogo->selecao2->ds_icone,
                    'id_jogo'=>$jogo->id,
                    'ds_nome_selecao1'=>$jogo->selecao1->ds_nome,
                    'ds_nome_selecao2'=>$jogo->selecao2->ds_nome,
                    'ds_estadio'=>$jogo->estadio->ds_nome,
                    'qt_aposta_selecao1'=>$qt_aposta_selecao1,
                    'qt_aposta_selecao2'=>$qt_aposta_selecao2,
                    'qt_pontos_resultado'=>$qt_pontos_resultado,
                    'qt_pontos_placar_cheio'=>$qt_pontos_placar_cheio,
                    'qt_pontos_placar_parcial'=>$qt_pontos_placar_parcial,
                    'qt_pontos_maximo' => $qt_pontos_maximo,
                    'qt_jogo_selecao1'=>$qt_jogo_selecao1,
                    'qt_jogo_selecao2'=>$qt_jogo_selecao2,
                    'id_final_jogo'=>$id_final_jogo,
                    'id_final_aposta'=>$id_final_aposta,
                    'class_selecao1'=>$class_selecao1,
                    'class_selecao2'=>$class_selecao2,
                    'class_placar1'=>$class_placar1,
                    'class_placar2'=>$class_placar2,
                    'class_X'=>$class_X,
                    'id_mostra1'=>$id_mostra1,
                    'id_mostra2'=>$id_mostra2, 
                	'id_penal'=>$jogo->id_penal,
                	'id_selecao_penal'=>$id_selecao_penal,
                	'ds_selecao_penal'=>$ds_selecao_penal,
                	'ds_icone_penal'=>$ds_icone_penal,
                	'id_mostra_penal'=>$id_mostra_penal,
                	'qt_pontos_bonus'=>$qt_pontos_bonus,
                	'class_penal'=>$class_penal,
                	'id_mostra_penal'=>$id_mostra_penal,
                	'ds_jogo_selecao_penal'=>$ds_jogo_selecao_penal,
                );
            }
           
        }
        
        $tb_cb_status[$this::COD_COMBO_STATUS_TODOS] = "Todos";
        $tb_cb_status[$this::COD_COMBO_STATUS_ABERTOS] = "Aberto";
        $tb_cb_status[$this::COD_COMBO_STATUS_FINALIZADOS] = "Finalizado";
        
        $tipos_rankings = TipoRanking::all();
        $tb_cb_rankings = array();
        foreach($tipos_rankings as $tipo_ranking){
            if ($tipo_ranking->id == env('CLASSIFICACAO_GERAL','1')){
                $tb_cb_rankings[$tipo_ranking->id] = "Todos";
            }
            else {
                $tb_cb_rankings[$tipo_ranking->id] = $tipo_ranking->ds_nome;
            }
        }
        
        view()->share('tb_status', $tb_cb_status);
        view()->share('tb_rankings', $tb_cb_rankings);
        if (!isset($tb_jogos)){
            $tb_jogos = array();
        }
        view()->share('tb_jogos', $tb_jogos);
        
        return view('apostas.telaMinhaConsultaLista');
    }

    public function telaConsultaGeralLista()
    {
        $usuarios = User::all();
        $tb_usuarios = array();
        foreach($usuarios as $usuario){
            $calculo = new PontuacaoUsuario();            
            $calculo->calcularUsuario($usuario->id);
                        
            if ($calculo->dt_hr_ult_aposta !== ""){
                $dt_ult_aposta = Carbon::parse(date_format($calculo->dt_hr_ult_aposta,'Y-m-d H:i:s'));
                $dt_ult_aposta= $dt_ult_aposta->format('d/m/Y H:i:s');
            }
            else {
                $dt_ult_aposta = "Sem Apostas";
            }
            
            $img_avatar_participante = "";
            $id_avatar_participante = false;
            
            if (Storage::disk('local')->exists('avatars/'.$usuario->id)){
                $img_aux = Storage::disk('local')->get('avatars/'.$usuario->id);
                $id_avatar_participante = true;
                $img_avatar_participante = "data:image/png;base64,".base64_encode($img_aux);
            }   
            
            $tb_usuarios[] = array('id_user'=>$usuario->id,
                                 'qt_apostas'=>$calculo->qt_apostas,
                                 'dt_hr_ult_aposta'=>$dt_ult_aposta,
                                 'ds_nome'=>$usuario->name,
                                 'qt_pontos_maximo'=>$calculo->qt_total_maximo,
                                 'qt_pontos_resultado'=>$calculo->qt_total_resultado,
                                 'qt_pontos_placar_cheio'=>$calculo->qt_total_placar_cheio,
                                 'qt_pontos_placar_parcial'=>$calculo->qt_total_placar_parcial,
                                 'id_avatar'=>$id_avatar_participante,
                                 'img_avatar'=>$img_avatar_participante
                                 );
        }
        
        view()->share('tb_usuarios', $tb_usuarios);
        return view('apostas.telaConsultaGeralLista');
    }
    
    public function telaDetalhePalpite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required|exists:users,id',
            'cd_status' => 'required',
            'cd_ranking' => 'required|exists:tipos_rankings,id'
        ]);
        
        if ($validator->fails()) {
            return redirect('apostas/telaConsultaGeralLista')
            ->withErrors($validator)
            ->withInput();
        }
        
        $tb_rankings = array();
        if ($request->cd_ranking == env('CLASSIFICACAO_GERAL','1')){
            $tiposRankings = TipoRanking::where('tp_fase',TipoRanking::TIPO_FASE_SIMPLES)
            ->get();
            foreach($tiposRankings as $tipoRanking){
                $tb_rankings[] = $tipoRanking->id;
            }
        }
        else {
            $tipoRanking = TipoRanking::where('id',$request->cd_ranking)->first();
            if ($tipoRanking->tp_fase == TipoRanking::TIPO_FASE_COMPOSTO){
                $fases = FaseRanking::where('id_ranking_composto',$request->cd_ranking)
                ->get();
                foreach($fases as $fase){
                    $tb_rankings[] = $fase->id_ranking_simples;
                }
            }
            else {
                $tb_rankings[] = $request->cd_ranking;
            }
        }
        
        $tb_status = array();
        if ($request->cd_status == $this::COD_COMBO_STATUS_TODOS){
            $tb_status = [StatusJogo::JOGO_PROGRAMADO, StatusJogo::JOGO_FINALIZADO,
                StatusJogo::JOGO_PREVISTO, StatusJogo::JOGO_APOSTA_ENCERRADA];
        }
        else if ($request->cd_status == $this::COD_COMBO_STATUS_ABERTOS){
            $tb_status = [StatusJogo::JOGO_PROGRAMADO, StatusJogo::JOGO_APOSTA_ENCERRADA,
                StatusJogo::JOGO_PREVISTO];
        }
        else if ($request->cd_status == $this::COD_COMBO_STATUS_FINALIZADOS){
            $tb_status[] = StatusJogo::JOGO_FINALIZADO;
        }
        
        $jogos = Jogo::where('id','>',0)
        ->whereIn('cd_status',$tb_status)
        ->whereIn('cd_ranking',$tb_rankings)
        ->with('selecao1')
        ->with('selecao2')
        ->with('estadio')
        ->with('selecao1.grupo')
        ->with('selecao1.handcap')
        ->with('selecao2.handcap')
        ->with('statusJogo')        
        ->orderBy('dt_jogo')
        ->orderBy('hr_jogo')
        ->get();
        
        
        foreach($jogos as $jogo){
            
            $pontuacao = new PontuacaoUsuario();
            
            $aposta = Aposta::where('id_jogo', $jogo->id)
            ->where('id_user', $request->id_usuario)
            ->first();
            $qt_aposta_selecao1 = "";
            $qt_aposta_selecao2 = "";
            
            $qt_pontos_resultado = "-";
            $qt_pontos_placar_cheio = "-";
            $qt_pontos_placar_parcial = "-";
            $qt_pontos_maximo = "-";
            $qt_pontos_bonus = "-";
            
            $qt_jogo_selecao1 = "";
            $qt_jogo_selecao2 = "";
            $id_final_jogo = "";
            $id_final_aposta = "";
            
            $class_selecao1 = "";
            $class_selecao2 = "";
            $class_placar1 = "";
            $class_X = "";
            $class_placar2 = "";
            $class_penal = "";
            
            $id_vencedor_penal = 0;
            
            $id_mostra1 = false;
            $id_mostra2 = false;
            $id_mostra_penal = false;
            
            $id_happy = false;
            
            if ($aposta != null){
                $qt_aposta_selecao1 = intval($aposta->qt_gols_selecao1);
                $qt_aposta_selecao2 = intval($aposta->qt_gols_selecao2);  
                $id_selecao_penal = $aposta->id_selecao_penal;
                $pontuacao->calcularProgramadoJogo($aposta->id);
                $qt_pontos_resultado = $pontuacao->qt_pontos_resultado;
                $qt_pontos_placar_cheio = $pontuacao->qt_pontos_placar_cheio;
                if ($pontuacao->qt_pontos_placar_parcial1 > $pontuacao->qt_pontos_placar_parcial2){
                    $qt_pontos_placar_parcial = $pontuacao->qt_pontos_placar_parcial1;
                }
                else {
                    $qt_pontos_placar_parcial = $pontuacao->qt_pontos_placar_parcial2;
                }
                $qt_pontos_bonus = $pontuacao->qt_pontos_bonus;
                $qt_pontos_maximo = $pontuacao->qt_pontos_maximo;
                
                if ($aposta->qt_gols_selecao1 == $aposta->qt_gols_selecao2){
                    $id_final_aposta = "X";
                }
                else if ($aposta->qt_gols_selecao1 > $aposta->qt_gols_selecao2){
                    $id_final_aposta = "1";
                }
                else {
                    $id_final_aposta = "2";
                }
                
                if ($jogo->cd_status == StatusJogo::JOGO_FINALIZADO){
                    $calculo = new CalculaResultado();
                    $calculo->calcular($aposta->id);
                    
                    $qt_pontos_resultado = $calculo->qt_pontos_resultado;
                    $qt_pontos_placar_cheio = $calculo->qt_pontos_placar_cheio;
                    $qt_pontos_placar_parcial = $calculo->qt_pontos_placar_parcial;
                    $qt_pontos_bonus = $calculo->qt_pontos_bonus;
                    $qt_pontos_maximo = $calculo->qt_pontos_total;
                    
                    $qt_jogo_selecao1 = $jogo->qt_gols_selecao1;
                    $qt_jogo_selecao2 = $jogo->qt_gols_selecao2;
                    
                    if ($jogo->qt_gols_selecao1 == $jogo->qt_gols_selecao2){
                        $id_final_jogo = "X";
                    }
                    else if ($jogo->qt_gols_selecao1 > $jogo->qt_gols_selecao2){
                        $id_final_jogo = "1";
                    }
                    else {
                        $id_final_jogo = "2";
                    }
                    if ($id_final_jogo == $id_final_aposta){
                        $id_happy = true;
                        if ($id_final_jogo == "1"){
                            $class_selecao1 = "green";
                        }
                        else if ($id_final_jogo == "2"){
                            $class_selecao2 = "green";                        
                        }
                        else {
                            $class_X = "green";                            
                        }
                        if ($jogo->qt_gols_selecao1 == $aposta->qt_gols_selecao1 &&
                            $jogo->qt_gols_selecao2 == $aposta->qt_gols_selecao2){
                            $class_placar1 = "green";
                            $class_X = "green";
                            $class_placar2 = "green";
                            if ($jogo->id_penal && $id_final_jogo == "X"){
                                if ($jogo->id_vencedor == $aposta->id_selecao_penal){
                                    $class_penal = "green";
                                    $id_mostra_penal = false;
                                }
                                else {
                                    $class_penal = "red";
                                    $id_mostra_penal = true;
                                    $id_vencedor_penal = $jogo->id_vencedor;
                                }
                            }
                        }
                        else {
                            if ($jogo->qt_gols_selecao1 == $aposta->qt_gols_selecao1){
                                $class_placar1 = "green";
                                $id_mostra2 = true;
                            }
                            else if ($jogo->qt_gols_selecao2 == $aposta->qt_gols_selecao2){
                                $class_placar2 = "green";
                                $id_mostra1 = true;
                            }
                            else {
                                $id_mostra1 = true;
                                $id_mostra2 = true;
                            }
                        }
                    }
                    else {
                        $class_selecao1 = "red";
                        $class_selecao2 = "red";
                        $class_placar1 = "red";
                        $class_X = "red";
                        $class_placar2 = "red";
                        $id_mostra1 = true;
                        $id_mostra2 = true;
                        if ($jogo->id_penal){                            
                            $class_penal = "red";
                            if ($id_final_jogo == "X"){
                                $id_mostra_penal = true;
                                $id_vencedor_penal = $jogo->id_vencedor;
                            }
                        }
                    }
                }
                
                $ds_selecao_penal = "";
                $ds_icone_penal = "";
                if ($id_selecao_penal > 0){
                    $selecaoPenal = Selecao::where('id',$id_selecao_penal)->first();
                    $ds_selecao_penal = $selecaoPenal->ds_nome;
                    $ds_icone_penal = $selecaoPenal->ds_icone;
                }
                $ds_vencedor_penal = "";
                $ds_icone_vencedor_penal = "";
                if ($id_vencedor_penal > 0){
                    $vencedorPenal = Selecao::where('id',$id_vencedor_penal)->first();
                    $ds_vencedor_penal = $vencedorPenal->ds_nome;
                    $ds_icone_vencedor_penal = $vencedorPenal->ds_icone;
                }
                
                $tb_jogos[] = array('dt_jogo'=>$jogo->dt_jogo,
                    'hr_jogo'=>$jogo->hr_jogo,
                    'cd_status'=>$jogo->cd_status,
                    'ds_ranking' =>$jogo->tipoRanking->ds_nome,
                    'cd_ranking' =>$jogo->cd_ranking,
                    'ds_grupo' =>$jogo->selecao1->grupo->ds_grupo,
                    'ds_icone1'=>$jogo->selecao1->ds_icone,
                    'ds_icone2'=>$jogo->selecao2->ds_icone,
                    'id_jogo'=>$jogo->id,
                    'ds_nome_selecao1'=>$jogo->selecao1->ds_nome,
                    'ds_nome_selecao2'=>$jogo->selecao2->ds_nome,
                    'ds_estadio'=>$jogo->estadio->ds_nome,
                    'qt_aposta_selecao1'=>$qt_aposta_selecao1,
                    'qt_aposta_selecao2'=>$qt_aposta_selecao2,
                    'qt_pontos_resultado'=>$qt_pontos_resultado,
                    'qt_pontos_placar_cheio'=>$qt_pontos_placar_cheio,
                    'qt_pontos_placar_parcial'=>$qt_pontos_placar_parcial,
                    'qt_pontos_maximo' => $qt_pontos_maximo,
                    'qt_jogo_selecao1'=>$qt_jogo_selecao1,
                    'qt_jogo_selecao2'=>$qt_jogo_selecao2,
                    'id_final_jogo'=>$id_final_jogo,
                    'id_final_aposta'=>$id_final_aposta,
                    'class_selecao1'=>$class_selecao1,
                    'class_selecao2'=>$class_selecao2,
                    'class_placar1'=>$class_placar1,
                    'class_placar2'=>$class_placar2,
                    'class_X'=>$class_X,
                    'id_mostra1'=>$id_mostra1,
                    'id_mostra2'=>$id_mostra2,
                    'id_happy'=>$id_happy,
                	'qt_pontos_bonus'=>$qt_pontos_bonus,
                    'id_selecao_penal'=>$id_selecao_penal,
                    'ds_selecao_penal'=>$ds_selecao_penal,
                    'ds_icone_penal'=>$ds_icone_penal,
                    'id_mostra_penal'=>$id_mostra_penal,
                    'class_penal'=>$class_penal,
                    'ds_vencedor_penal'=>$ds_vencedor_penal,
                    'ds_icone_vencedor_penal'=>$ds_icone_vencedor_penal
                );
            }
        }
        
        $status_jogos = StatusJogo::all();
        $tb_status[0] = "Selecione";
        foreach($status_jogos as $status_jogo){
            $tb_status[$status_jogo->id] = $status_jogo->ds_status;
        }
        
        $tipos_rankings = TipoRanking::all();
        $tb_rankings = array();
        foreach($tipos_rankings as $tipo_ranking){
            if ($tipo_ranking->id == env('CLASSIFICACAO_GERAL','1')){
                $tb_rankings[$tipo_ranking->id] = "Todos";
            }
            else {
                $tb_rankings[$tipo_ranking->id] = $tipo_ranking->ds_nome;
            }
        }
        
        $usuario_palpite = User::where('id',$request->id_usuario)->first();
        
        view()->share('usuario_palpite', $usuario_palpite);
        view()->share('tb_status', $tb_status);
        view()->share('tb_rankings', $tb_rankings);
        if (!isset($tb_jogos)){
            $tb_jogos = array();
        }
        view()->share('tb_jogos', $tb_jogos);
        
        return view('apostas.telaDetalhePalpite');
    }
}
