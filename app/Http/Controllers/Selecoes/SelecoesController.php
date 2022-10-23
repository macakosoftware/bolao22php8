<?php

namespace App\Http\Controllers\Selecoes;

use App\Models\Selecao;
use App\Models\Grupo;
use App\Models\Handcap;
use App\Http\Controllers\LogadoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SelecoesController extends LogadoController
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
    
    public function telaManutencao()
    {  
        $selecoes = Selecao::where('id','>',0)
        ->orderBy('ds_nome')
        ->get();
        
        view()->share('selecoes', $selecoes);
        return view('selecoes.telaManutencao');
    }

    /*
    public function telaConsultaLista()
    {
    	$selecoes = Selecao::where('id','>',0)
    	->orderBy('ds_nome')
    	->get();
    	
    	view()->share('selecoes', $selecoes);
        return view('selecoes.telaConsultaLista');
    }
    */
    
    public function telaEditar(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'id_selecao' => 'required|exists:selecoes,id'
    	]);
    	
    	if ($validator->fails()) {
    		return redirect('selecoes/telaManutencao')
    		->withErrors($validator)
    		->withInput();
    	}
    	
    	$grupos = Grupo::all();
    	$handicaps = Handcap::orderBy('id')->get();
        $tb_handicaps = array();
    	foreach($handicaps as $handicap){
    	    $tb_handicaps[$handicap->id] = $handicap->ds_handcap;
    	}
    	
    	$selecao = Selecao::where('id',$request->id_selecao)->first();
    	
    	view()->share('selecao', $selecao);
    	view()->share('grupos', $grupos);
    	view()->share('tb_handicaps', $tb_handicaps);
    	return view('selecoes.telaEditar');
    }
    
    public function editar(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'id_selecao' => 'required|exists:selecoes,id',
    	    'ds_nome' => 'required',
    	    'cd_handicap' => 'required',    	    
    	]);
    	
    	if ($validator->fails()) {
    		return redirect('selecoes/telaManutencao')
    		->withErrors($validator)
    		->withInput();
    	}
    	
    	if ($request->hasFile('brasao_time')) {
    	    	
        	if (!$request->file('brasao_time')->isValid()) {
        	    return redirect('selecoes/telaManutencao')->with('erro', 'Brasão/Símbolo do time não é válido!');
        	}
        	
        	$extensao = $request->brasao_time->extension();
        	$extensao = strtoupper($extensao);
        	if ($extensao != 'PNG' &&
        	    $extensao != 'JPG' &&
        	    $extensao != 'JPGE' &&
        	    $extensao != 'GIF'){
        	    return redirect('selecoes/telaManutencao')->with('erro', 'Brasão/Símbolo tem que ser um arquivo de formato de foto (PNG, JPG, GIF). Extensão informada:'.$extensao);
        	}
        	
    	}
    	
    	DB::beginTransaction();
    	
    	$selecao = Selecao::where('id',$request->id_selecao)->first();
    	$selecao->ds_nome = $request->ds_nome;
    	$selecao->cd_handcap = $request->cd_handicap;
    	$selecao->save();
    	
    	if ($request->hasFile('brasao_time')){
    	    $file = $request->brasao_time;
    	    $file->move(public_path('images/brasoes'),$selecao->ds_icone);
    	}
    	
    	DB::commit();
    	
    	return redirect('selecoes/telaManutencao')->with('sucesso', 'Seleção alterada com sucesso!');
    }

    public function manutencao(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'submit' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect('selecoes/telaManutencao')
            ->withErrors($validator)
            ->withInput();
        }
        
        if ($request->has('submit')){
            if ($request->submit == 'incluir'){
                $handicaps = Handcap::orderBy('id')->get();
                $tb_handicaps = array();
                foreach($handicaps as $handicap){
                    $tb_handicaps[$handicap->id] = $handicap->ds_handcap;
                }
                
                view()->share('tb_handicaps',$tb_handicaps);
                
                return view('selecoes.telaIncluir');
            }
        }
    }
    
    public function incluir(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ds_nome' => 'required',
            'cd_handicap' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect('selecoes/telaManutencao')
            ->withErrors($validator)
            ->withInput();
        }
        
        if (!$request->hasFile('brasao_time')) {
            return redirect('selecoes/telaManutencao')->with('erro', 'Brasão/Símbolo do time não foi selecionado!');
        }
        
        if (!$request->file('brasao_time')->isValid()) {
            return redirect('selecoes/telaManutencao')->with('erro', 'Brasão/Símbolo do time não é válido!');
        }
        
        $extensao = $request->brasao_time->extension();
        $extensao = strtoupper($extensao);
        if ($extensao != 'PNG' && 
            $extensao != 'JPG' &&
            $extensao != 'JPGE' &&
            $extensao != 'GIF'){
                return redirect('selecoes/telaManutencao')->with('erro', 'Brasão/Símbolo tem que ser um arquivo de formato de foto (PNG, JPG, GIF). Extensão informada:'.$extensao);
        }
        
        DB::beginTransaction();
                
        $selecao = new Selecao();
        $selecao->ds_nome = $request->ds_nome;
        $selecao->ds_icone = '';
        $selecao->id_grupo = Grupo::SEM_GRUPO;
        $selecao->cd_handcap = $request->cd_handicap;
        $selecao->ds_cor = '';
        $selecao->ds_fonte = '';
        $selecao->ds_cor2 = '';
        $selecao->save();
        
        $ds_icone = 'brasao_'.$selecao->id;
        $selecao->ds_icone = $ds_icone;
        $selecao->save();
        
        $file = $request->brasao_time;
        $file->move(public_path('images/brasoes'),$ds_icone);
        
        DB::commit();
        
        return redirect('figurinhas/telaEncerrarProposta')->with('sucesso', 'Time Incluído com Sucesso!');
    }
}
