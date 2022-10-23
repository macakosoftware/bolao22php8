<?php

namespace App\Http\Controllers\Rankings;

use App\Models\StatusRanking;
use App\Models\TipoRanking;
use App\Http\Controllers\LogadoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\FaseRanking;
use App\Events\TipoRankingFechadoEvent;

class TiposRankingsController extends LogadoController
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
    
    public function telaManutencaoLista()
    {
        $tipos = TipoRanking::where('id','>',0)
        ->with('statusRanking')
        ->get();
       
        view()->share('tipos', $tipos);
                
        return view('rankings.telaManutencaoLista');
    }
    
    public function telaEditarTipo(Request $request)
    {
        $validator = Validator::make($request->all(), [            
            'id_tipo' => 'required|exists:tipos_rankings,id'
        ]);
        
        if ($validator->fails()) {
            return redirect('tiposRankings/telaManutencaoLista')
            ->withErrors($validator)
            ->withInput();
        }
        
        $tipo = TipoRanking::where('id',$request->id_tipo)->first();
        
        $tb_status[StatusRanking::ABERTO] = "Aberto";
        $tb_status[StatusRanking::FECHADO] = "Fechado";
        
        $tb_fases[TipoRanking::TIPO_FASE_GERAL] = "Geral";
        $tb_fases[TipoRanking::TIPO_FASE_SIMPLES] = "Simples";
        $tb_fases[TipoRanking::TIPO_FASE_COMPOSTO] = "Composto";
        
        view()->share('tipo', $tipo);
        view()->share('tb_status', $tb_status);
        view()->share('tb_fases', $tb_fases);
                
        return view('rankings.telaEditarTipo');
    }
    
    public function editarTipo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_tipo' => 'required|exists:tipos_rankings,id',
            'ds_nome' => 'required',
            'dt_limite' => 'required|date_format:d/m/Y',
            'hr_limite' => 'required|date_format:H:i',
            'cd_status' => 'required',
            'tp_fase' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect('tiposRankings/telaEditarTipo?id_tipo='.$request->id_tipo)
            ->withErrors($validator)
            ->withInput();
        }
        
        $dt_limite = Carbon::createFromFormat('d/m/Y',$request->dt_limite)->format('Y-m-d');
        
        $tipo = TipoRanking::where('id',$request->id_tipo)->first();
        
        $tipo->ds_nome = $request->ds_nome;
        $tipo->dt_limite = $dt_limite;
        $tipo->hr_limite = $request->hr_limite.':00';
        $tipo->cd_status = $request->cd_status;
        $tipo->tp_fase = $request->tp_fase;
        $tipo->save();
        
        if ($tipo->cd_status == StatusRanking::FECHADO){
            event(new TipoRankingFechadoEvent($tipo));
        }
        
        return redirect('tiposRankings/telaManutencaoLista')->with('sucesso', 'Tipo de Ranking - '.$tipo->ds_nome.' Atualizado com Sucesso!');
    }
    
    public function telaControleRanking()
    {
        $tipos = TipoRanking::where('id','>',0)
        ->with('statusRanking')
        ->get();
        
        $tb_status = array();
        $status = StatusRanking::all();
        foreach($status as $status_reg){
            $tb_status[$status_reg->id] = $status_reg->ds_status;
        }
        
        view()->share('tipos', $tipos);
        view()->share('tb_status', $tb_status);
        
        return view('rankings.telaControleRanking');
    }
    
    public function controleRanking(Request $request)
    {
        DB::beginTransaction();
        
        $tipos = TipoRanking::where('id','>',0)
        ->get();
        
        foreach($tipos as $tipo){
            if ($request->exists('cd_status_'.$tipo->id)){
                if ($tipo->cd_status != $request->{'cd_status_'.$tipo->id}){
                    $tipo->cd_status = $request->{'cd_status_'.$tipo->id};
                    $tipo->save();
                }
            }
        }
        
        DB::commit();
        
        return redirect('home')->with('sucesso', 'Controle de Ranking Atualizado com Sucesso!');
    }
   
    public function telaIncluir()
    {
        $rankings = TipoRanking::where('tp_fase',TipoRanking::TIPO_FASE_SIMPLES)
                    ->where('cd_status',StatusRanking::ABERTO)
                    ->get();
        
        $tb_fases['S'] = 'Simples';
        $tb_fases['C'] = 'Composto';
        $tb_fases['G'] = 'Geral';
        
        $tb_series[''] = 'Sem Série';
        $tb_series['A'] = 'Série A';
        $tb_series['B'] = 'Série B';
        
        view()->share('rankings',$rankings);
        view()->share('tb_fases', $tb_fases);
        view()->share('tb_series', $tb_series);
        
        return view('rankings.telaIncluirTipoRanking');
    }
    
    public function incluir(Request $request)
    {
        $validator = Validator::make($request->all(), [            
            'ds_nome' => 'required',
            'ds_abreviado' => 'required',
            'dt_limite' => 'required|date_format:d/m/Y',
            'hr_limite' => 'required|date_format:H:i',            
            'tp_fase' => 'required',            
        ]);
        
        if ($validator->fails()) {
            return redirect('tiposRankings/telaIncluir')
            ->withErrors($validator)
            ->withInput();
        }
        
        $id_handicap_casa = false;
        if ($request->id_handicap_casa){
            $id_handicap_casa = true;
        }
        
        $dt_limite = Carbon::createFromFormat('d/m/Y',$request->dt_limite)->format('Y-m-d');
        $hr_limite = $request->hr_limite.':00';
        
        $tipo = new TipoRanking();
        $tipo->ds_nome = $request->ds_nome;
        $tipo->ds_abreviado = $request->ds_abreviado;
        $tipo->cd_status = StatusRanking::ABERTO;
        $tipo->qt_apostas = 0;
        $tipo->id_grupo = 0;
        $tipo->ds_badge = "";
        $tipo->dt_limite = $dt_limite;
        $tipo->hr_limite = $hr_limite;
        $tipo->tp_serie = $request->tp_serie;
        if ($tipo->tp_serie == null){
            $tipo->tp_serie = "";
        }
        $tipo->tp_fase = $request->tp_fase;
        $tipo->id_handicap_casa = $id_handicap_casa;
        $tipo->pc_premio1 = 0;
        $tipo->pc_premio2 = 0;
        $tipo->pc_premio3 = 0;
        $tipo->save();
        
        if ($request->tp_fase == TipoRanking::TIPO_FASE_COMPOSTO){
            foreach($request->cd_ranking as $ranking_reg){
                $fase = new FaseRanking();
                $fase->id_ranking_composto = $tipo->id;
                $fase->id_ranking_simples = $ranking_reg;
                $fase->save();
            }            
        }
        
        return redirect('home')->with('sucesso', 'Tipo de Ranking incluído com sucesso!');
    }
}
