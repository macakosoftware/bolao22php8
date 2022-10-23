<?php

namespace App\Http\Controllers\Figurinhas;


use App\Models\HistoricoPontoXP;
use App\Http\Controllers\LogadoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Jogador;
use App\Models\JogadorUsuario;
use App\Funcoes\GeraFigurinha;
use Illuminate\Support\Facades\Storage;
use App\Models\Selecao;
use App\Models\TransacaoFigurinha;
use App\Funcoes\ValidaTransacao;
use App\Funcoes\RecuperaFigurinhas;
use App\Models\TransacaoProposta;
use App\Models\PropostaJogador;
use App\Models\NotificacaoAlbum;
use App\Funcoes\AtualizaProposta;
use App\Funcoes\VerificaFigurinhaColecao;
use App\Funcoes\GeraAlbumPDF;

class FigurinhasController extends LogadoController
{
    protected const IMAGEM_BROTHETA = "images/brotheta.png";
    
    public const DIR_FONTES ='/assets/fonts/';
        
    public const FONTE_BUCKS ='10_Bucks.ttf';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    public function telaCompra()
    {
        $user = Auth::user();
        
        $hists = HistoricoPontoXP::where('id_user',$user->id)->get();
        
        view()->share('usuario',$user);
        view()->share('hists',$hists);
        
        return view('figurinhas.telaCompra');
    }
    
    public function comprar(Request $request){        
        $validator = Validator::make($request->all(), [
            'qt_figurinhas' => 'required'            
        ]);
        
        if ($validator->fails()) {
            return redirect('usuarios/telaCompra')
            ->withErrors($validator)
            ->withInput();
        }
        
        $usuario = Auth::user();
        
        if ($usuario->qt_pontos_xp < $request->qt_figurinhas){
            return redirect('figurinhas/telaCompra')->with('erro', 'Você não possui brothetas suficientes para realizar a compra!');
        }
        
        $usuario->qt_pontos_xp = $usuario->qt_pontos_xp - $request->qt_figurinhas;
        $usuario->save();
                
        $hist = new HistoricoPontoXP();
        $hist->id_user = $usuario->id;
        $hist->tp_transacao = HistoricoPontoXP::TIPO_SAIDA;
        $hist->dt_transacao = date('Y-m-d');
        $hist->ds_transacao = 'Compra de '.$request->qt_figurinhas.' Figurinha(s)';
        $hist->vl_transacao = $request->qt_figurinhas;
        $hist->save();
        
        //$maximo = Jogador::max('nr_fim_random');
        $maximo = Jogador::max('id');
        
        $tb_figurinhas = array();
        for($i=0;$i<$request->qt_figurinhas;$i++){
            $num = rand(1,$maximo);
             
            /*
            $jogador = Jogador::where('nr_ini_random','<=',$num)
            ->where('nr_fim_random','>=',$num)
            ->first();
            */            
            $jogador = Jogador::where('id',$num)->first();

            $figUser = new JogadorUsuario();
            $figUser->id_jogador = $jogador->id;
            $figUser->id_user = $usuario->id;
            $figUser->save();
            
            $tb_figurinhas[] = $jogador->id;
        }
        
        view()->share('tb_figurinhas',$tb_figurinhas);
        return view('figurinhas.telaNovasFigurinhas');
    }
    
    public function mostrar(Request $request){
        
        $usuario = Auth::user();
        
        $figUsuario = JogadorUsuario::where('id_jogador',$request->id_jogador)
                      ->where('id_user',$usuario->id)
                      ->first();
                
        $id_gerar = false;
        if ($request->has('id_gerar')){
            if ($request->id_gerar == "S"){
                $id_gerar = true;
            }
        }
                      
        if ($figUsuario == null){
            $gerador = new GeraFigurinha($request->id_jogador);
            $image = $gerador->vazia();
            
            return response($image->encode('png'),200)->header('Content-Type','image/png');
        }
        else {
            if ($id_gerar){
                $gerador = new GeraFigurinha($request->id_jogador);
                $gerador->gerar();
            }
            
            $file = Storage::get('figurinhas/figurinha_'.$request->id_jogador.'.png');
            return response($file, 200)->header('Content-Type', 'image/png');
        }
    }
    
    public function telaListarMinhas()
    {
        $recuperador = new RecuperaFigurinhas($this->usuario);
        $retorno = $recuperador->recuperar();
                
        if ($retorno == false){
            return redirect('home')->with('erro', $recuperador->ds_mensagem);
        }
        
        view()->share('tb_figurinhas',$recuperador->tb_figurinhas);
        
        return view('figurinhas.telaListarMinhas');
    }
    
    public function verAlbum(Request $request)
    {
        $id_selecao = 1;
        if ($request->has('id_selecao')){
            $id_selecao = $request->id_selecao;
        }

        $tb_selecoes = array();
        $selecoes = Selecao::where('id','<=',Selecao::PAGINA_MAXIMA_ALBUM)
                    ->orderBy('ds_nome')->get();
        foreach($selecoes as $reg){
            $tb_selecoes[$reg->id] = $reg->ds_nome;
        }
        
        $selecao = Selecao::where('id',$id_selecao)->with('grupo')->first();
        
        $jogadores = Jogador::where('id_selecao',$id_selecao)
                     ->orderBy('nr_camisa')
                     ->get();
        
        $tb_figurinhas = array();
        foreach($jogadores as $jogador){
            $figUsuario = JogadorUsuario::where('id_jogador',$jogador->id)
                          ->where('id_user',$this->usuario->id)                          
                          ->get();
            
            $qt_figurinhas = count($figUsuario);
            
            $tb_figurinhas[] = array('id_jogador'=>$jogador->id,
                                     'qt_figurinhas'=>$qt_figurinhas,
                                     'jogador'=>$jogador
                                    );
        }
        
        $id_ant = $id_selecao - 1;
        if ($id_selecao == Selecao::PAGINA_MAXIMA_ALBUM){
            $id_prox = 0;
        }
        else {
            $id_prox = $id_selecao + 1;
        }
        if ($id_selecao < 3){
            $id0 = 0;
            $id1 = 1;
            $id2 = 2;
            $id3 = 3;
            $id4 = 4;
            $id5 = 5;
            $id6 = 6;
        }
        else if ($id_selecao > 30){
            $id0 = 27;
            $id1 = 28;
            $id2 = 29;
            $id3 = 30;
            $id4 = 31;
            $id5 = 32;
            $id6 = 0;
        }
        else {
            $id0 = $id_selecao - 3;
            $id1 = $id_selecao - 2;
            $id2 = $id_selecao - 1;
            $id3 = $id_selecao;
            $id4 = $id_selecao + 1;
            $id5 = $id_selecao + 2;
            $id6 = $id_selecao + 3;
        }
        
        view()->share('selecao',$selecao);
        view()->share('tb_selecoes',$tb_selecoes);
        view()->share('id_ant',$id_ant);
        view()->share('id_prox',$id_prox);
        view()->share('id_selecao',$id_selecao);
        view()->share('id0',$id0);
        view()->share('id1',$id1);
        view()->share('id2',$id2);
        view()->share('id3',$id3);
        view()->share('id4',$id4);
        view()->share('id5',$id5);
        view()->share('id6',$id6);
        view()->share('tb_figurinhas',$tb_figurinhas);
        
        return view('figurinhas.verAlbum');
    }
    
    public function telaResumo()
    {
        $total_figurinhas = Jogador::count();
        
        $recuperador = new RecuperaFigurinhas($this->usuario);
        $retorno = $recuperador->recuperar();
        if ($retorno == false){
            return redirect('home')->with('erro', $recuperador->ds_mensagem);
        }
     
        $pc_figurinhas = ($recuperador->qt_tiradas / $total_figurinhas) * 100;
        
        $qt_completar = $total_figurinhas - $recuperador->qt_tiradas;
        view()->share('total_figurinhas',$total_figurinhas);
        view()->share('qt_tiradas',$recuperador->qt_tiradas);
        view()->share('qt_repetidas',$recuperador->qt_repetidas);
        view()->share('qt_completar',$qt_completar);
        view()->share('pc_figurinhas',$pc_figurinhas);
        view()->share('tb_figurinhas',$recuperador->tb_figurinhas);
        
        return view('figurinhas.telaResumo');
    }
    
    public function telaTrocar(Request $request){
        $validator = Validator::make($request->all(), [
            'id_jogador' => 'required|exists:jogadores,id'
        ]);
        
        if ($validator->fails()) {
            return redirect('home')
            ->withErrors($validator)
            ->withInput();
        }
        
        $validador = new ValidaTransacao($this->usuario->id, $request->id_jogador);
        $retorno = $validador->validar();
        if ($retorno == false){
            return redirect('home')->with('erro', $validador->ds_mensagem);
        }
        
        $qt_aux = $validador->qt_figurinhas - $validador->qt_transacoes;
        $tb_qtd = array();
        for($i=1;$i<=$qt_aux;$i++){
            $tb_qtd[$i] = $i;
        }
        
        $jogador = Jogador::where('id',$request->id_jogador)->first();
        
        $id_tela_oferecer = "N";
        if ($request->has('id_tela_oferecer')){
            $id_tela_oferecer = $request->id_tela_oferecer;
        }
        view()->share('id_tela_oferecer',$id_tela_oferecer);
        
        
        view()->share('tb_qtd',$tb_qtd);
        view()->share('jogador',$jogador);
        
        return view('figurinhas.telaTrocar');
    }
    
    public function trocar(Request $request){
        $validator = Validator::make($request->all(), [
            'id_jogador' => 'required|exists:jogadores,id',            
        ]);
        
        if ($validator->fails()) {
            return redirect('figurinhas/telaTrocar')
            ->withErrors($validator)
            ->withInput();
        }
        
       $validador = new ValidaTransacao($this->usuario->id, $request->id_jogador);
       $retorno = $validador->validar();
       if ($retorno == false){
           return redirect('telaTrocar')->with('erro', $validador->ds_mensagem);
       }
        
       $transacao = new TransacaoFigurinha();
       $transacao->id_user = $this->usuario->id;
       $transacao->id_jogador = $request->id_jogador;
       $transacao->tp_transacao = TransacaoFigurinha::TIPO_TROCA;
       $transacao->vl_venda = 0;
       $transacao->cd_status = TransacaoFigurinha::STATUS_ABERTA;
       $transacao->ds_observacao = 'Troca de Figurinha';       
       $transacao->save();
       
       $id_tela_oferecer = false;
       if ($request->has('id_tela_oferecer')){
           if ($request->id_tela_oferecer == "S"){
               $id_tela_oferecer = true;
           }
       }
               
       $mensagem = 'Troca da Figurinha Postada com Sucesso. Aguarde Propostas!';
       
       if ($id_tela_oferecer){
           $recuperador = new RecuperaFigurinhas($this->usuario);
           $retorno = $recuperador->recuperar();
                      
           foreach($recuperador->tb_figurinhas as $figurinha){
               if ($figurinha['qt_figurinhas'] > 1){
                   $transacao = TransacaoFigurinha::where('id_user',$this->usuario->id)
                   ->where('id_jogador',$figurinha['id_jogador'])
                   ->where('cd_status',TransacaoFigurinha::STATUS_ABERTA)
                   ->get();
                   if (count($transacao) == 0){
                       $tb_aux[] = $figurinha;
                   }
               }
           }
           
           if (isset($tb_aux)){
               return redirect('figurinhas/telaOferecerFigurinha')->with('sucesso', $mensagem);
           }
           else {
               return redirect('home')->with('sucesso', $mensagem);
           }
       }
       else{
           return redirect('home')->with('sucesso', $mensagem);
       }
    }
    
    public function telaVender(Request $request){
        $validator = Validator::make($request->all(), [
            'id_jogador' => 'required|exists:jogadores,id'
        ]);
        
        if ($validator->fails()) {
            return redirect('home')
            ->withErrors($validator)
            ->withInput();
        }
        
        $validador = new ValidaTransacao($this->usuario->id, $request->id_jogador);
        $retorno = $validador->validar();
        if ($retorno == false){
            return redirect('home')->with('erro', $validador->ds_mensagem);
        }
        
        $tb_qtd = array();
        $qt_aux = $validador->qt_figurinhas - $validador->qt_transacoes;
        for($i=1;$i<=$qt_aux;$i++){
            $tb_qtd[$i] = $i;
        }
        
        $jogador = Jogador::where('id',$request->id_jogador)->first();
        
        $id_tela_oferecer = "N";
        if ($request->has('id_tela_oferecer')){
            $id_tela_oferecer = $request->id_tela_oferecer;
        }
        view()->share('id_tela_oferecer',$id_tela_oferecer);
        
        view()->share('tb_qtd',$tb_qtd);
        view()->share('jogador',$jogador);
        
        return view('figurinhas.telaVender');
    }
    
    public function vender(Request $request){
        $validator = Validator::make($request->all(), [
            'id_jogador' => 'required|exists:jogadores,id',            
            'vl_venda' => 'required'            
        ]);
        
        if ($validator->fails()) {
            return redirect('figurinhas/telaVender')
            ->withErrors($validator)
            ->withInput();
        }
               
        $validador = new ValidaTransacao($this->usuario->id, $request->id_jogador);
        $retorno = $validador->validar();
        if ($retorno == false){
            return redirect('figurinhas/telaVender')->with('erro', $validador->ds_mensagem);
        }
        
        $vl_venda = substr($request->vl_venda, 1);
        $vl_venda = str_replace(',', '.', $vl_venda);
        if ($vl_venda <= 0){
            return redirect('figurinhas/telaVender')->with('erro', 'Valor de Venda tem que ser maior que zero!');
        }
        if ($vl_venda > TransacaoFigurinha::VALOR_MAXIMO_VENDA){
        	return redirect('figurinhas/telaVender')->with('erro', 'Valor de Venda não pode ser maior que '.TransacaoFigurinha::VALOR_MAXIMO_VENDA.'!');
        }
        
        if (trim($request->ds_observacao) == ""){
            $ds_observacao = 'Venda Figurinha';
        }
        else {
            $ds_observacao = $request->ds_observacao;
        }
        
        $transacao = new TransacaoFigurinha();
        $transacao->id_user = $this->usuario->id;
        $transacao->id_jogador = $request->id_jogador;
        $transacao->tp_transacao = TransacaoFigurinha::TIPO_VENDA;
        $transacao->vl_venda = $vl_venda;
        $transacao->cd_status = TransacaoFigurinha::STATUS_ABERTA;
        $transacao->ds_observacao = $ds_observacao;        
        $transacao->save();
        
        $mensagem = 'Venda da Figurinha Postada com Sucesso. Aguarde Propostas!';
        
        $id_tela_oferecer = false;
        if ($request->has('id_tela_oferecer')){
            if ($request->id_tela_oferecer == "S"){
                $id_tela_oferecer = true;
            }
        }
        
        if ($id_tela_oferecer){
            $recuperador = new RecuperaFigurinhas($this->usuario);
            $retorno = $recuperador->recuperar();
            
            foreach($recuperador->tb_figurinhas as $figurinha){
                if ($figurinha['qt_figurinhas'] > 1){
                    $transacao = TransacaoFigurinha::where('id_user',$this->usuario->id)
                    ->where('id_jogador',$figurinha['id_jogador'])
                    ->where('cd_status',TransacaoFigurinha::STATUS_ABERTA)
                    ->get();
                    if (count($transacao) == 0){
                        $tb_aux[] = $figurinha;
                    }
                }
            }
            
            if (isset($tb_aux)){
                return redirect('figurinhas/telaOferecerFigurinha')->with('sucesso', $mensagem);
            }
            else {
                return redirect('home')->with('sucesso', $mensagem);
            }
        }
        else{
            return redirect('home')->with('sucesso', $mensagem);
        }
    }
    
    public function telaProcurarPropostas(){
        $transacoes = TransacaoFigurinha::where('cd_status',TransacaoFigurinha::STATUS_ABERTA)
                      ->where('id_user','<>',$this->usuario->id)
                      ->orderBy('updated_at','DESC')
                      ->get();

        if (count($transacoes) == 0){
            return redirect('home')->with('erro', 'Não há nenhuma oferta nesse momento!');
        }
        
        foreach($transacoes as $transacao){
            $fig = JogadorUsuario::where('id_user',$this->usuario->id)
                   ->where('id_jogador',$transacao->id_jogador)
                   ->first();            
            if ($fig == null){
                
                $transa = TransacaoFigurinha::where('id_jogador',$transacao->id_jogador)
                          ->where('cd_status',TransacaoFigurinha::STATUS_ABERTA)
                          ->whereHas('propostas',function($q){
                              $q->where('id_user_proposta',$this->usuario->id)
                                ->where('cd_status',TransacaoProposta::STATUS_ENVIADA);
                          })
                          ->get();
                if (count($transa) == 0){
                    $transacoesAux[] = $transacao;
                }
            }
        }
        if (isset($transacoesAux)){
	        if (count($transacoesAux) == 0){
	            return redirect('home')->with('erro', 'Não há nenhuma oferta de figurinhas que você não tenha!');
	        }
        }
        else {
        	return redirect('home')->with('erro', 'Não há nenhuma oferta de figurinhas que você não tenha!');
        }
        
        view()->share('transacoes',$transacoesAux);
        
        return view('figurinhas.telaProcurarPropostas');
    }
    
    public function telaCriarProposta(Request $request){
        $validator = Validator::make($request->all(), [
            'id_oferta' => 'required|exists:transacoes_figurinhas,id'
        ]);
        
        if ($validator->fails()) {
            return redirect('figurinhas/telaProcurarPropostas')
            ->withErrors($validator)
            ->withInput();
        }
        
        $transacao = TransacaoFigurinha::where('id',$request->id_oferta)->first();
        
        $proposta = TransacaoProposta::where('id_transacao',$request->id_oferta)
                    ->where('id_user_proposta',$this->usuario->id)
                    ->where('cd_status',TransacaoProposta::STATUS_ENVIADA)
                    ->first();
        if ($proposta != null){
            return redirect('figurinhas/telaProcurarPropostas')->with('erro', 'Você já tem uma proposta aberta para essa figurinha. Aguarde a conclusão!');
        }
        
        $recuperador = new RecuperaFigurinhas($this->usuario);
        $retorno = $recuperador->recuperar();
        if ($retorno == false){
            return redirect('figurinhas/telaProcurarPropostas')->with('erro', $recuperador->ds_mensagem);
        }
        
        $tem_repetida = false;
        $tb_figurinhas = array();
        foreach($recuperador->tb_figurinhas as $figurinha){
            if ($figurinha['qt_figurinhas'] > 1){
                $tem_repetida = true;
                
                $jogAux = Jogador::where('id',$figurinha)->first();
                
                $tb_figurinhas[] = array('figurinha'=>$figurinha,
                'id_ele_tem'=>VerificaFigurinhaColecao::verificar($transacao->usuario, $jogAux)         
                );
            }
        }
        
        view()->share('tem_repetida',$tem_repetida);
        if ($tem_repetida){
            view()->share('tb_figurinhas',$tb_figurinhas);
        }
        
        view()->share('transacao',$transacao);
        
        return view('figurinhas.telaCriarProposta');
    }
    
    public function criarProposta(Request $request){
        $validator = Validator::make($request->all(), [
            'id_oferta' => 'required|exists:transacoes_figurinhas,id',            
        ]);
        
        if ($validator->fails()) {
            return redirect('figurinhas/telaCriarProposta')
            ->withErrors($validator)
            ->withInput();
        }
        
        if (trim($request->vl_oferta) == ""){
            $vl_oferta = 0;
        }
        else {
            $vl_oferta = substr($request->vl_oferta, 1);
            $vl_oferta = str_replace(',', '.', $vl_oferta);
        }
        if ($vl_oferta < 0){
        	return redirect('figurinhas/telaCriarProposta?id_oferta='.$request->id_oferta)->with('erro', 'Valor Não Pode Ser Negativo!');
        }
        if ($vl_oferta > TransacaoFigurinha::VALOR_MAXIMO_VENDA){
        	return redirect('figurinhas/telaCriarProposta?id_oferta='.$request->id_oferta)->with('erro', 'Valor da Oferta não pode ser maior que '.TransacaoFigurinha::VALOR_MAXIMO_VENDA);
        }
        
        $ds_observacao = "";
        if ($request->has('ds_observacao')){
        	$ds_observacao = $request->ds_observacao;
        }
        if ($ds_observacao == null){
        	$ds_observacao = "";
        }
        
        $proposta = new TransacaoProposta();
        $proposta->id_transacao = $request->id_oferta;
        $proposta->id_user_proposta = $this->usuario->id;
        $proposta->vl_proposta = $vl_oferta;
        $proposta->cd_status = TransacaoProposta::STATUS_ENVIADA;
        $proposta->ds_observacao = $ds_observacao;
        $proposta->ds_resposta = "";
        $proposta->save();
        
        if ($request->has('tb_figurinhas')){
            if (count($request->tb_figurinhas) > 0){
                foreach($request->tb_figurinhas as $figurinha){
                    $propJogador = new PropostaJogador();
                    $propJogador->id_proposta = $proposta->id;
                    $propJogador->id_jogador = $figurinha;
                    $propJogador->save();
                }
            }
        }
        
        $transaFigurinha = TransacaoFigurinha::where('id',$request->id_oferta)->first();
        
        $notificacao = new NotificacaoAlbum();
        $notificacao->id_user = $transaFigurinha->id_user;
        $notificacao->tp_notificacao = NotificacaoAlbum::TIPO_NOTIFICACAO_OFERTA;
        $notificacao->id_transacao = $transaFigurinha->id;
        $notificacao->id_proposta = $proposta->id;
        $notificacao->tp_resposta = NotificacaoAlbum::TIPO_RESPOSTA_ENVIADO;
        $notificacao->id_user_from = $this->usuario->id;
        $notificacao->id_lido = false;
        $notificacao->ds_observacao = 'Oferta Enviada por '.$transaFigurinha->jogador->ds_nome.' de '.$transaFigurinha->jogador->selecao->ds_nome;
        $notificacao->save();
        
        return redirect('figurinhas/telaProcurarPropostas')->with('sucesso', 'Proposta criada com sucesso!');
    }
    
    public function telaPropostasRecebidas(){
        $usuario = $this->usuario;
            
        $propostas = TransacaoFigurinha::where('id_user',$this->usuario->id)
                     ->where('cd_status',TransacaoFigurinha::STATUS_ABERTA)
                     ->with('propostas')
                     ->get();
        
        if (count($propostas) == 0){
            return redirect('home')->with('erro', 'Você não tem nenhuma proposta aberta!');
        }
        
        foreach($propostas as $proposta){            
            $qt_ofertas = 0;
            foreach($proposta->propostas as $oferta){
                if ($oferta->cd_status == TransacaoProposta::STATUS_ENVIADA){                    
                    $qt_ofertas++;
                }
            }
            if ($qt_ofertas > 0){
                $saida[] = $proposta;
            }
        }
        
        if(!isset($saida)){
            return redirect('home')->with('erro', 'Você não tem nenhuma proposta com ofertas enviadas!');
        }
        if (count($saida) == 0){
            return redirect('home')->with('erro', 'Você não tem nenhuma proposta com ofertas enviadas!');
        }
        
        view()->share('propostas',$saida);
        
        return view('figurinhas.telaPropostasRecebidas');
    }
    
    public function visualizarProposta(Request $request){
        $validator = Validator::make($request->all(), [
            'id_proposta' => 'required|exists:transacoes_propostas,id',
        ]);
        
        if ($validator->fails()) {
            return redirect('figurinhas/telaPropostasRecebidas')
            ->withErrors($validator)
            ->withInput();
        }

        if ($request->submit == AtualizaProposta::ACAO_ACEITAR ||
            $request->submit == AtualizaProposta::ACAO_REJEITAR){
            $atualizador = new AtualizaProposta($request->id_proposta, $request->submit);
            $retorno = $atualizador->atualizar();
            if ($retorno){
                return redirect('home')->with('sucesso', $atualizador->ds_mensagem);
            }
            else {
                return redirect('figuritnhas/telaPropostasRecebidas')->with('erro',$atualizador->ds_mensagem);   
            }            
        }
        
        $proposta = TransacaoProposta::where('id',$request->id_proposta)->first();
        
        $jogadores = PropostaJogador::where('id_proposta',$request->id_proposta)->get();
        
        view()->share('proposta',$proposta);
        view()->share('jogadores',$jogadores);
        
        return view('figurinhas.visualizarProposta');
    }
    
    public function atualizarProposta(Request $request){
        $validator = Validator::make($request->all(), [
            'id_proposta' => 'required|exists:transacoes_propostas,id',
        ]);
        
        if ($validator->fails()) {
            return redirect('figurinhas/visualizarProposta?id_proposta='.$request->id_proposta)
            ->withErrors($validator)
            ->withInput();
        }
        
        $atualizador = new AtualizaProposta($request->id_proposta, $request->submit);
        $retorno = $atualizador->atualizar();
        if ($retorno){
            return redirect('home')->with('sucesso', $atualizador->ds_mensagem);
        }
        else {
            return redirect('figurinhas/visualizarProposta?id_proposta='.$request->id_proposta)
            ->with('erro',$atualizador->ds_mensagem);
        } 
    }
    
    public function telaRecebidasFinalizadas(){
        
        $transacoes = TransacaoFigurinha::where('id_user',$this->usuario->id)
                      ->where('cd_status',TransacaoFigurinha::STATUS_FECHADA)
                      ->with('usuario')
                      ->with('jogador')
                      ->with('propostas')
                      ->get();
        
        view()->share('transacoes',$transacoes);                      
                      
        return view('figurinhas.telaRecebidasFinalizadas');
    }
    
    public function telaPropostasAceitas(){
        
        $propostas = TransacaoProposta::where('cd_status',TransacaoProposta::STATUS_ACEITA)
        ->where('id_user_proposta',$this->usuario->id)
        ->with('jogadoresTroca')
        ->with('transacao')
        ->with('transacao.jogador')
        ->get();
        
        view()->share('propostas',$propostas);
        return view('figurinhas.telaPropostasAceitas');
    }
    
    public function telaPropostasRejeitadas(){
        
        $propostas = TransacaoProposta::where('cd_status',TransacaoProposta::STATUS_REJEITADA)
                     ->where('id_user_proposta',$this->usuario->id)
                     ->with('jogadoresTroca')
                     ->with('transacao')
                     ->with('transacao.jogador')
                     ->get();
        
        view()->share('propostas',$propostas);
        return view('figurinhas.telaPropostasRejeitadas');
    }
    
    public function consultaProposta(Request $request){
        $validator = Validator::make($request->all(), [
            'id_proposta' => 'required|exists:transacoes_propostas,id',
        ]);
        
        if ($validator->fails()) {
            return redirect('figurinhas/telaPropostasRecebidas')
            ->withErrors($validator)
            ->withInput();
        }
        
        $proposta = TransacaoProposta::where('id',$request->id_proposta)->first();
        
        $jogadores = PropostaJogador::where('id_proposta',$request->id_proposta)->get();
        
        view()->share('proposta',$proposta);
        view()->share('jogadores',$jogadores);
        
        return view('figurinhas.consultaProposta');
    }
    
    public function telaListarRepetidas()
    {
        $recuperador = new RecuperaFigurinhas($this->usuario);
        $retorno = $recuperador->recuperar();
        
        if ($retorno == false){
            return redirect('home')->with('erro', $recuperador->ds_mensagem);
        }
        
        foreach($recuperador->tb_figurinhas as $figurinha){
            if ($figurinha['qt_figurinhas'] > 1){
                $tb_aux[] = $figurinha;
            }
        }
        
        if (!isset($tb_aux)){
            return redirect('home')->with('erro', 'Você não possui nenhuma figurinha repetida');
        }
        else {
            if (count($tb_aux) == 0){
                return redirect('home')->with('erro', 'Você não possui nenhuma figurinha repetida');
            }
        }
        
        view()->share('tb_figurinhas',$tb_aux);
        
        return view('figurinhas.telaListarRepetidas');
    }
    
    public function telaCancelarOferta(){
        $ofertas = TransacaoProposta::where('id_user_proposta',$this->usuario->id)
                   ->where('cd_status',TransacaoProposta::STATUS_ENVIADA)
                   ->with('transacao')
                   ->with('jogadoresTroca')
                   ->get();
        if (count($ofertas) == 0){
            return redirect('home')->with('erro', 'Você não possui nenhuma oferta aberta!');
        }
        
        view()->share('ofertas',$ofertas);
        
        return view('figurinhas.telaCancelarOferta');
    }
    
    public function cancelarOferta(Request $request){
        $validator = Validator::make($request->all(), [
            'id_oferta' => 'required|exists:transacoes_propostas,id',
        ]);
        
        if ($validator->fails()) {
            return redirect('figurinhas/telaCancelarOferta')
            ->withErrors($validator)
            ->withInput();
        }
        
        $oferta = TransacaoProposta::where('id',$request->id_oferta)->first();
        $oferta->ds_resposta = 'Oferta cancelada pelo próprio usuário em '.date('d/m/Y').' as '.date('H:i:s');
        $oferta->cd_status = TransacaoProposta::STATUS_CANCELADA;
        $oferta->save();
        
        $notificacao = new NotificacaoAlbum();
        $notificacao->id_user = $oferta->transacao->usuario->id;
        $notificacao->tp_notificacao = NotificacaoAlbum::TIPO_NOTIFICACAO_PROPOSTA;
        $notificacao->id_transacao = $oferta->transacao->id;
        $notificacao->id_proposta = $oferta->id;
        $notificacao->tp_resposta = NotificacaoAlbum::TIPO_RESPOSTA_CANCELADO;
        $notificacao->id_user_from = $oferta->id_user_proposta;
        $notificacao->id_lido = false;
        $notificacao->save();
        
        return redirect('home')->with('sucesso', 'Oferta Cancelada com Sucesso!');
    }
    
    public function telaVerMinhasOfertas(){
        $ofertas = TransacaoProposta::where('id_user_proposta',$this->usuario->id)        
        ->with('transacao')
        ->with('jogadoresTroca')
        ->orderBy('updated_at','DESC')
        ->get();
        if (count($ofertas) == 0){
            return redirect('home')->with('erro', 'Você não possui nenhuma oferta no momento!');
        }
        
        foreach($ofertas as $oferta){            
            $notificacao = NotificacaoAlbum::where('id_proposta',$oferta->id)
                           ->where('id_user',$this->usuario->id)
                           ->first();            
            if ($notificacao != null){                
                $notificacao->id_lido = true;
                $notificacao->save();
            }
        }
        
        view()->share('ofertas',$ofertas);
        
        return view('figurinhas.telaVerMinhasOfertas');
    }
    
    public function visualizarOferta(Request $request){
        $validator = Validator::make($request->all(), [
            'id_oferta' => 'required|exists:transacoes_propostas,id',
        ]);
        
        if ($validator->fails()) {
            return redirect('figurinhas/telaPropostasRecebidas')
            ->withErrors($validator)
            ->withInput();
        }
        
        $proposta = TransacaoProposta::where('id',$request->id_oferta)
                    ->with('transacao')
                    ->first();
        
        $jogadores = PropostaJogador::where('id_proposta',$request->id_oferta)
                    ->with('jogador')
                    ->get();
        
        view()->share('proposta',$proposta);
        view()->share('jogadores',$jogadores);
        
        return view('figurinhas.visualizarOferta');
    }
    
    public function telaOferecerFigurinha()
    {
        $recuperador = new RecuperaFigurinhas($this->usuario);
        $retorno = $recuperador->recuperar();
        
        if ($retorno == false){
            return redirect('home')->with('erro', $recuperador->ds_mensagem);
        }
        
        foreach($recuperador->tb_figurinhas as $figurinha){
            if ($figurinha['qt_figurinhas'] > 1){
                $transacao = TransacaoFigurinha::where('id_user',$this->usuario->id)
                             ->where('id_jogador',$figurinha['id_jogador'])
                             ->where('cd_status',TransacaoFigurinha::STATUS_ABERTA)
                             ->get();
                if (count($transacao) == 0){
                    $tb_aux[] = $figurinha;
                }
            }
        }
        
        if (!isset($tb_aux)){
            return redirect('home')->with('erro', 'Você não possui nenhuma figurinha repetida ou todas já tem transação');
        }
        else {
            if (count($tb_aux) == 0){
                return redirect('home')->with('erro', 'Você não possui nenhuma figurinha repetida ou todas já tem transação');
            }
        }
        
        view()->share('tb_figurinhas',$tb_aux);
                
        return view('figurinhas.telaOferecerFigurinha');
    }
    
    public function oferecerFigurinha(Request $request){
        $validator = Validator::make($request->all(), [
            'id_figurinha' => 'required|exists:jogadores,id',
        ]);
        
        if ($validator->fails()) {
            return redirect('figurinhas/telaOferecerFigurinha')
            ->withErrors($validator)
            ->withInput();
        }
        
        
        $id_tela_oferecer = "N";
        if ($request->has('id_tela_oferecer')){
            $id_tela_oferecer = "S";
        }
        
        if ($request->has('submit')){
            if ($request->submit == 'trocar'){
                return redirect('figurinhas/telaTrocar?id_jogador='.$request->id_figurinha.'&id_tela_oferecer='.$id_tela_oferecer);
            }
            else if ($request->submit == 'vender'){
                return redirect('figurinhas/telaVender?id_jogador='.$request->id_figurinha.'&id_tela_oferecer='.$id_tela_oferecer);
            }
        }        
    }
    
    public function telaPropostaRecebidaDetalhe(Request $request){
        $validator = Validator::make($request->all(), [
            'id_proposta' => 'required|exists:transacoes_figurinhas,id',
        ]);
        
        if ($validator->fails()) {
            return redirect('figurinhas/telaPropostasRecebidas')
            ->withErrors($validator)
            ->withInput();
        }
        
        $ofertas = TransacaoProposta::where('id_transacao',$request->id_proposta)
                   ->where('cd_status',TransacaoProposta::STATUS_ENVIADA)
                   ->get();

        $transacao = TransacaoFigurinha::where('id',$request->id_proposta)->first(); 
        if ($transacao->cd_status == TransacaoFigurinha::STATUS_FECHADA){
        	$notificacoes = NotificacaoAlbum::where('id_transacao',$transacao->id)->get();
        	if (count($notificacoes) > 0){
        	    foreach($notificacoes as $notificacao){        	
        	       $notificacao->id_lido = true;
        	       $notificacao->save();
        	    }
        	}
        	
        	return redirect('home')
        	->with('sucesso', 'Proposta já foi encerrada.');
        }
                   
        view()->share('transacao',$transacao);
        view()->share('ofertas',$ofertas);
        
        return view('figurinhas.telaPropostaRecebidaDetalhe');
    }
    
    public function telaVerMinhasPropostas(){
        $transacoes = TransacaoFigurinha::where('id_user',$this->usuario->id)
                      ->get();
        
        view()->share('transacoes',$transacoes);
        return view('figurinhas.telaVerMinhasPropostas');
    }
    
    public function telaVerMinhasPropostasDetalhe(Request $request){
        $validator = Validator::make($request->all(), [
            'id_proposta' => 'required|exists:transacoes_figurinhas,id',
        ]);
        
        if ($validator->fails()) {
            return redirect('figurinhas/telaVerMinhasPropostas')
            ->withErrors($validator)
            ->withInput();
        }
        
        $transacao = TransacaoFigurinha::where('id',$request->id_proposta)->first();
        
        $ofertas = TransacaoProposta::where('id_transacao',$request->id_proposta)->get();
                      
        view()->share('ofertas',$ofertas);
        view()->share('transacao',$transacao);
        return view('figurinhas.telaVerMinhasPropostasDetalhe');
    }
    
    public function telaEncerrarProposta(){
        $transacoes = TransacaoFigurinha::where('id_user',$this->usuario->id)
                      ->where('cd_status',TransacaoFigurinha::STATUS_ABERTA)
        ->get();
        
        view()->share('transacoes',$transacoes);
        return view('figurinhas.telaEncerrarProposta');
    }
    
    public function encerrarProposta(Request $request){
        $validator = Validator::make($request->all(), [
            'id_transacao' => 'required|exists:transacoes_figurinhas,id',
        ]);
        
        if ($validator->fails()) {
            return redirect('figurinhas/telaEncerrarProposta')
            ->withErrors($validator)
            ->withInput();
        }
        
        $ofertas = TransacaoProposta::where('id_transacao',$request->id_transacao)
                   ->where('cd_status',TransacaoProposta::STATUS_ENVIADA)
                   ->get();
        foreach($ofertas as $oferta){
            $oferta->ds_resposta = 'Oferta cancelada pois usuário encerrou proposta!';
            $oferta->cd_status = TransacaoProposta::STATUS_CANCELADA;
            $oferta->save();
        }
        
        $transacao = TransacaoFigurinha::where('id',$request->id_transacao)->first();
        $transacao->cd_status = TransacaoFigurinha::STATUS_FECHADA;
        $transacao->save();

        
        return redirect('figurinhas/telaEncerrarProposta')->with('sucesso', 'Proposta Encerrada com Sucesso!');
    }
        
    public function gerarAlbumPDF(){
     
        set_time_limit(0);
        
        $gerador = new GeraAlbumPDF($this->usuario->id);
        $gerador->gerar($gerador::METODO_TELA);
        
    }
}
