<?php

namespace App\Http\Controllers\Jogadores;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\LogadoController;
use App\Models\Perfil;
use Illuminate\Support\Facades\Redirect;
use App\Models\Jogador;
use Carbon\Carbon;
use App\Models\Posicao;
use League\Csv\Reader;

class JogadoresController extends LogadoController
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
     * @return \Illuminate\Http\Response
     */
    public function telaImportar()
    {   
        return view('jogadores.telaImportar');
    }
    
    public function importar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'arquivo_jogadores' => 'required|file'
        ]);
        
        $jogadores = Jogador::all();
        if (count($jogadores) > 0){
            foreach($jogadores as $jogador){
                $jogador->delete();
            }
        }
        
        $arquivo = $request->file('arquivo_jogadores');
        $nr_random = 0;
        $nr_id = 0;
        
        $reader = Reader::createFromFileObject($arquivo->openFile());
        $reader->setHeaderOffset(0);
        $reader->setDelimiter(';');
        $records = $reader->getRecords();
        foreach($records as $offset => $record){
                    
            try{
                $dt_nascimento = Carbon::createFromFormat('d/m/Y',trim($record['nascimento']))->format('Y-m-d');
            }
            catch (\Exception $e){
                echo '-->'.$record['nascimento'].'<--<BR>';
                exit;
            }
            
            $vl_preco = 0;
            $valor = trim($record['valor']);
            if (strpos($valor,'M €') !== false){
                $valor = str_replace('M €', '', $valor);
                $valor = str_replace(',','.',$valor);
                $vl_preco = trim($valor);
                $vl_preco = $vl_preco * 1000;
            }
            else if(strpos($valor,'mil €') !== false){
                $valor = str_replace('mil €', '', $valor);
                $valor = str_replace(',','.',$valor);
                $vl_preco = trim($valor);                
            }
            
            $id_posicao = 0;
            $ds_posicao = trim($record['posicao']);
            if ($ds_posicao == Posicao::GUARDA_REDES){
                $id_posicao = Posicao::COD_GOLEIRO;
            }
            else if ($ds_posicao == Posicao::DEFESA_CENTRAL){
                $id_posicao = Posicao::COD_ZAGUEIRO;
            }
            else if ($ds_posicao == Posicao::LATERAL_ESQUERDO){
                $id_posicao = Posicao::COD_LATERAL_ESQUERDO;
            }
            else if ($ds_posicao == Posicao::LATERAL_DIREITO){
                $id_posicao = Posicao::COD_LATERAL_DIREITO;
            }
            else if ($ds_posicao == Posicao::MEDIO_DEFENSIVO){
                $id_posicao = Posicao::COD_MEIA_DEFENSIVO;
            }
            else if ($ds_posicao == Posicao::MEDIO_CENTRAL){
                $id_posicao = Posicao::COD_MEIA_CENTRAL;
            }
            else if ($ds_posicao == Posicao::MEDIO_OFENSIVO){
                $id_posicao = Posicao::COD_MEIA_CENTRAL;
            }
            else if ($ds_posicao == Posicao::EXTREMO_ESQUERDO){
                $id_posicao = Posicao::COD_PONTA_ESQUERDA;
            }
            else if ($ds_posicao == Posicao::EXTREMO_DIREITO){
                $id_posicao = Posicao::COD_PONTA_DIREITA;
            }
            else if ($ds_posicao == Posicao::PONTA_DE_LANCA){
                $id_posicao = Posicao::COD_PONTA_LANCA;
            }
            else if ($ds_posicao == Posicao::SEGUNDO_AVANCADO){
                $id_posicao = Posicao::COD_ATACANTE;
            }
            else if ($ds_posicao == Posicao::MEDIO_ESQUERDO){
                $id_posicao = Posicao::COD_ALA_ESQUERDO;
            }
            else if ($ds_posicao == Posicao::MEDIO_DIREITO){
                $id_posicao = Posicao::COD_ALA_DIREITO;
            }
            
            $nr_random++;
            $nr_id++;
            
            $jogador = new Jogador();
            $jogador->id = $nr_id;
            $jogador->id_selecao = intval(trim($record['id_selecao']));
            $jogador->ds_selecao = trim($record['selecao']);
            $jogador->ds_numero = trim($record['numero']);
            $jogador->ds_nome = trim($record['nome']);
            $jogador->ds_abreviado = trim($record['abreviado']);
            $jogador->ds_posicao = trim($record['posicao']);
            $jogador->dt_nascimento = $dt_nascimento;
            $jogador->ds_time = trim($record['clube']);            
            $jogador->ds_valor = trim($record['valor']);
            $jogador->id_posicao = $id_posicao;
            $jogador->vl_preco = $vl_preco;
            $jogador->nr_ini_random = $nr_random;
            $nr_random += (Jogador::PRECO_MAXIMO - $jogador->vl_preco);
            $jogador->nr_fim_random = $nr_random;
            $jogador->tp_jogador = trim($record['tipo']);
            $jogador->save();
        }
        
        return redirect('home')->with('sucesso', 'Jogadores Importados com Sucesso!');
    }
    
    public function teste()
    {
        $maximo = Jogador::max('nr_fim_random');

        /*
        for($i=0;$i<=5;$i++){
            $num = rand(1,$maximo);
            
            $jogador = Jogador::where('nr_ini_random','<=',$num)
                       ->where('nr_fim_random','>=',$num)
                       ->first();

        }
        */
        
        // $ids = [1, 45, 135, 177, 194, 3, 217, 222, 243, 2, 4, 5, 6, 7, 8, 9, 10, 11, 781, 782, 783, 784, 785, 654, 673, 734, 705];
        
        /*
        foreach($ids as $id){
            $gerador = new GeraFigurinha($id);
            $gerador->gerar();
            $figurinhas[] = array('id'=>$id);
        }
        */
        /*
        for($i=1;$i<=10;$i++){
            $num = rand(1,501);
            try {
            $gerador = new GeraFigurinha($num);
            $gerador->gerar();
            }
            catch(\Exception $e){
                echo $num;
                exit;                
            }
            $figurinhas[] = array('id'=>$num);
        }
        */
        $figurinhas = array();
        
        view()->share('figurinhas',$figurinhas);
        
        return view('jogadores.teste');
    }
}
