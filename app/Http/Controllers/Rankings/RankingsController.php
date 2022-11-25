<?php

namespace App\Http\Controllers\Rankings;

use App\Models\Ranking;
use App\Http\Controllers\LogadoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\TipoRanking;
use App\Funcoes\GeraInformeRanking;
use App\Models\StatusRanking;
use App\Funcoes\GeraFechamentoRanking;
use App\Funcoes\GeraCertificado;
use App\Funcoes\GeraBadge;
use App\Models\HistoricoRanking;

class RankingsController extends LogadoController
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
    
    public function telaFiltroConsulta()
    {  
    	$tiposRankings = TipoRanking::where('id','>',0)->orderBy('ds_nome', 'asc')->get();
        $tb_rankings = array();
    	foreach($tiposRankings as $tipo){
    	    $tb_rankings[$tipo->id] = $tipo->ds_nome;
    	}
    	        
        view()->share('tb_rankings', $tb_rankings);
        return view('rankings/telaFiltroConsulta');
    }
    
    public function telaConsultaLista(Request $request)
    {  
    	$validator = Validator::make($request->all(), [
    			'id_ranking' => 'required|exists:tipos_rankings,id'
    	]);
    	
    	if ($validator->fails()) {
    		return redirect('home')
    		->withErrors($validator)
    		->withInput();
    	}
    	
    	$tipoRanking = TipoRanking::where('id',$request->id_ranking)->first();
    	
        $rankings = Ranking::where('cd_ranking',$request->id_ranking)
                    ->with('tipoRanking')
                    ->with('usuario')
                    ->orderBy('qt_pontos', 'desc')
                    ->orderBy('qt_acertos_cheio', 'desc')
                    ->orderBy('qt_acertos_parcial', 'desc')
                    ->orderBy('qt_acertos_resultado', 'desc')
                    ->orderBy('qt_pontos_maior', 'desc')
                    ->get();
        
        if (count($rankings) == 0){
        	return redirect('rankings/telaFiltroConsulta')->with('erro', 'Não há nenhum ranking gerado ainda para essa fase!');
        }
        
        $qt_posicao = 0;
        $tb_ranking = array();
        foreach($rankings as $ranking){
            $qt_posicao++;
           
            $img_avatar_participante = "";
            $id_avatar_participante = false;
            
            if (Storage::disk('local')->exists('avatars/'.$ranking->usuario->id)){
                $img_aux = Storage::disk('local')->get('avatars/'.$ranking->usuario->id);
                $id_avatar_participante = true;
                $img_avatar_participante = "data:image/png;base64,".base64_encode($img_aux);
            }   
            
            $hist = HistoricoRanking::where('cd_ranking',$ranking->cd_ranking)
                    ->where('id_user',$ranking->id_user)
                    ->orderBy('dt_hr_ranking','desc')
                    ->first();
            $dif = 0;                    
            $id_sobe = false;
            $id_desce = false;
            if ($hist != null){
                if ($hist->qt_posicao != 0){
                    $dif = $ranking->qt_posicao - $hist->qt_posicao;
                    if ($dif < 0){
                        $dif = $dif * -1;
                        $id_sobe = true;
                    }
                    else if ($dif > 0){
                        $id_desce = true;
                    }
                }
            }
            
            $tb_ranking[] = array('nr_posicao'=>$qt_posicao,
                                  'ds_nome'=>$ranking->usuario->name,
                                  'qt_pontos'=>$ranking->qt_pontos,
                                  'qt_acertos_resultado'=>$ranking->qt_acertos_resultado,
                                  'qt_acertos_cheio'=>$ranking->qt_acertos_cheio,
                                  'qt_acertos_parcial'=>$ranking->qt_acertos_parcial,
                                  'qt_pontos_resultado'=>$ranking->qt_pontos_resultado,
                                  'qt_pontos_placar_cheio'=>$ranking->qt_pontos_placar_cheio,
                                  'qt_pontos_placar_parcial'=>$ranking->qt_pontos_placar_parcial,
                                  'qt_pontos_maior'=>$ranking->qt_pontos_maior,
                                  'qt_apostas'=>$ranking->qt_apostas,
                                  'id_avatar'=>$id_avatar_participante,
                                  'img_avatar'=>$img_avatar_participante,
                                  'id_ranking'=>$request->id_ranking,
                                  'id_user'=>$ranking->usuario->id,
                                  'id_sobe'=>$id_sobe,
                                  'id_desce'=>$id_desce,
                                  'dif'=>$dif
                                 );
        }
        
        view()->share('tipoRanking',$tipoRanking);
        view()->share('tb_ranking', $tb_ranking);
        return view('rankings/telaConsultaLista');
    }

    public function telaFiltroInforme()
    {
        $tiposRankings = TipoRanking::where('id','>',0)->orderBy('ds_nome')->get();
        $tb_rankings = array();
        foreach($tiposRankings as $tipo){
            $tb_rankings[] = array('id'=>$tipo->id,
                                   'ds_nome'=>$tipo->ds_nome);
        }
        
        view()->share('tb_rankings', $tb_rankings);        
        return view('rankings/telaFiltroInforme');
    }
    
    public function gerarInforme(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cd_ranking' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect('rankings/telaFiltroInforme')
            ->withErrors($validator)
            ->withInput();
        }
        
        $informe = new GeraInformeRanking($request->cd_ranking);
        $informe->gerar();
        
        return $informe->pdf->download('informe_ranking.pdf');
    }
    
    public function telaFiltroFechamento()
    {
        $tiposRankings = TipoRanking::where('cd_status',StatusRanking::ABERTO)
                         ->orderBy('ds_nome')
                         ->get();
        
        if (count($tiposRankings) == 0){
            return redirect('home')->with('erro', 'Não há nenhum ranking para ser fechado!');
        }

        $tb_rankings = array();                 
        foreach($tiposRankings as $tipo){
            $tb_rankings[$tipo->id] = $tipo->ds_nome;
        }
        
        view()->share('tb_rankings', $tb_rankings);
        return view('rankings/telaFiltroFechamento');
    }
    
    public function gerarFechamento(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cd_ranking' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect('rankings/telaFiltroFechamento')
            ->withErrors($validator)
            ->withInput();
        }
        
        $ranking = TipoRanking::whereId($request->cd_ranking)->get();
        $ranking->cd_status = StatusRanking::FECHADO;
        $ranking->save();

        $badge = new GeraBadge($request->cd_ranking);
        $badge->gerar();
        
        $fechamento = new GeraFechamentoRanking($request->cd_ranking);
        $fechamento->gerar();
        
        return $fechamento->pdf->download('fechamento_ranking.pdf');
    }
    
    public function telaFiltroCertificado()
    {
        $tiposRankings = TipoRanking::where('cd_status',StatusRanking::FECHADO)
                         ->whereIn('tp_fase',[TipoRanking::TIPO_FASE_SIMPLES,TipoRanking::TIPO_FASE_GERAL])
                         ->orderBy('ds_nome')
                         ->get();
        
        if (count($tiposRankings) == 0){
            return redirect('home')->with('erro', 'Não há nenhum ranking fechado ainda!');
        }
                         
        $tb_rankings = array();
        foreach($tiposRankings as $tipo){
            $tb_rankings[$tipo->id] = $tipo->ds_nome;
        }
        
        view()->share('tb_rankings', $tb_rankings);
        return view('rankings/telaFiltroCertificado');
    }
    
    public function gerarCertificado(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cd_ranking' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect('rankings/telaFiltroCertificado')
            ->withErrors($validator)
            ->withInput();
        }
        
        $certificado = new GeraCertificado($request->cd_ranking, 1);
        $certificado->gerar(GeraCertificado::METODO_TELA);
    }
}
