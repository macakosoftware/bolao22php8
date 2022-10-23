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

class UsuariosController extends LogadoController
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
            if ($this->usuario->cd_perfil != Perfil::PERFIL_ADMINISTRADOR){
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
        $tb_perfis[0] = "Selecione um Perfil";
        $perfis = Perfil::all();        
        foreach($perfis as $perfil){
            $tb_perfis[$perfil->id] = $perfil->ds_perfil;
        }
        
        view()->share('tb_perfis', $tb_perfis);
        
        return view('usuarios.incluir');
    }
    
    public function incluir(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',            
            'cd_perfil' => 'required|exists:perfis,id'
        ]);
        
        if ($validator->fails()) {
            return redirect('usuarios/telaIncluir')
            ->withErrors($validator)
            ->withInput();
        }
        
        $nome = $request->nome;
        $email = $request->email;
        $password = $request->password;
        $cd_perfil = $request->cd_perfil;
        
        $usuario = new User();
        $usuario->name = $nome;
        $usuario->email = $email;
        $usuario->password = bcrypt($password);
        $usuario->cd_perfil = $cd_perfil;
        $usuario->cd_pagamento = Pagamento::PENDENTE_PAGAMENTO;
        $usuario->vl_pagamento = 0;
        $usuario->vl_premio = 0;
        $usuario->qt_pontos_xp = 0;
        $usuario->save();
        
        event(new UsuarioIncluidoEvent($usuario, $password));
        
        return redirect('home')->with('mensagem', 'Usuário Incluído com Sucesso!');
    }
    
    public function telaConsultarLista()
    {  
        $usuarios = User::where('id','>',0)
                    ->with('perfil')
                    ->with('pagamento')
                    ->orderBy('name')->get();
        
        view()->share('usuarios', $usuarios);
        
        return view('usuarios.consultarLista');
    }
    
    public function telaManutencaoLista()
    {  
        $usuarios = User::where('id','>',0)
                    ->with('perfil')
                    ->orderBy('name')->get();
        
        view()->share('usuarios', $usuarios);
        
        return view('usuarios.telaManutencaoLista');
    }
    
    public function telaAlterar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id'
        ]);
        
        if ($validator->fails()) {
            return redirect('usuarios/telaManutencaoLista')
            ->withErrors($validator)
            ->withInput();
        }
        
        $user = User::where('id',$request->id)->first();
        
        $tb_perfis[0] = "Selecione um Perfil";
        $perfis = Perfil::all();
        foreach($perfis as $perfil){
            $tb_perfis[$perfil->id] = $perfil->ds_perfil;
        }
        
        view()->share('usuario', $user);
        view()->share('tb_perfis', $tb_perfis);
        
        return view('usuarios.alterar');
    }
    
    public function Alterar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|exists:users,id',
            'nome' => 'required',
            'email' => 'required|email',
            'password' => 'required_if:id_alterar_senha,true|confirmed',
            'cd_perfil' => 'required|exists:perfis,id'
        ]);
        
        if ($validator->fails()) {
            return redirect('usuarios/telaAlterar?id='.$request->id_user)
            ->withErrors($validator)
            ->withInput();
        }
       
        $usuario = User::where('id',$request->id_user)->first();
        $usuario->name = $request->nome;
        $usuario->email = $request->email;
        if ($request->id_alterar_senha){
            $usuario->password = bcrypt($request->password);
        }
        $usuario->cd_perfil = $request->cd_perfil;
        $usuario->save();
                
        return redirect('usuarios/telaManutencaoLista')->with('sucesso', 'Usuário Alterado com Sucesso!');
    }
    
    public function telaPagamentoSelecao()
    {
    	
    	$usuarios = User::where('id','>',0)
    	->where('cd_pagamento',Pagamento::PENDENTE_PAGAMENTO)
    	->with('perfil')
    	->with('pagamento')
    	->orderBy('name')->get();
    	
    	view()->share('usuarios', $usuarios);
    	
    	return view('usuarios.telaPagamentoSelecao');
    }
    
    public function telaPagamentoDetalhe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user_selecao' => 'required:exists:users,id',            
        ]);
        
        if ($validator->fails()) {
            return redirect('usuarios/telaPagamentoSelecao')
            ->withErrors($validator)
            ->withInput();
        }
        
    	$formas = FormaPagamento::where('id','>',0)
    	->orderBy('ds_nome')
    	->get();
    	
        $tb_formas = array();
    	foreach($formas as $forma){
    	    $tb_formas[$forma->id] = $forma->ds_nome;
    	}
    	
    	$usuario = User::where('id',$request->id_user_selecao)->first();
    	
    	view()->share('tb_formas',$tb_formas);
    	view()->share('usuario_selecao', $usuario);
    	
    	return view('usuarios.telaPagamentoDetalhe');
    }
    
    public function incluirPagamento(Request $request)
    {     
        $validator = Validator::make($request->all(), [
            'id_user_selecao' => 'required|exists:users,id',
            'cd_forma'=>'required|exists:formas_pagamentos,id',
            'dt_pagamento' => 'required|date_format:d/m/Y',
            'hr_pagamento' => 'required|date_format:H:i',
            'vl_pagamento'=>'required',
        ]);
        
        if ($validator->fails()) {
            return redirect('usuarios/telaPagamentoDetalhe?id_user_selecao='.$request->id_user_selecao)
            ->withErrors($validator)
            ->withInput();
        }
        
        $dt_pagamento = Carbon::createFromFormat('d/m/Y',$request->dt_pagamento)->format('Y-m-d');
        $hr_pagamento = $request->hr_jogo;
        
        $vl_pagamento = substr($request->vl_pagamento, 2);
        $vl_pagamento = str_replace(',', '.', $vl_pagamento);
                
        $vl_dif = 0;
        $vl_joia = $vl_pagamento;
        $id_quitado = false;
        $usuario = User::where('id', $request->id_user_selecao)->first();
        $usuario->vl_pagamento += $vl_pagamento;
        if ($usuario->vl_pagamento >= User::VALOR_JOIA_PREMIO){
            $usuario->cd_pagamento = Pagamento::PAGO;
            $id_quitado = true;
        }
        if ($usuario->vl_pagamento > User::VALOR_JOIA_PREMIO){
            $vl_dif = $usuario->vl_pagamento - User::VALOR_JOIA_PREMIO;
            $vl_joia = $vl_pagamento - $vl_dif;
            $usuario->vl_pagamento = User::VALOR_JOIA_PREMIO;
        }
        $usuario->save();
                
        $ds_observacao = '';
        if ($request->has('ds_observacao')){
            if (trim($request->ds_observacao) != ''){
                $ds_observacao = $request->ds_observacao;
            }
        }
        
        $movimento = new MovimentoPagamento();
        $movimento->id_user = $request->id_user_selecao;
        $movimento->cd_forma = $request->cd_forma;
        $movimento->vl_movimento = $vl_pagamento;
        $movimento->vl_joia = $vl_joia;
        $movimento->ds_observacao = $ds_observacao;
        $movimento->dt_hr_pagamento = $dt_pagamento." ".$hr_pagamento.":00";
        $movimento->save();
            
        if ($vl_dif > 0){
            $hist = new HistCreditoUsuario();
            $hist->id_user = $request->id_user_selecao;
            $hist->tp_movimento = HistCreditoUsuario::TIPO_MOVIMENTO_ENTRADA;
            $hist->ds_observacao = "Crédito Referente ao pagamento da Jóia Prêmio no Valor de $".$vl_pagamento." ";
            $hist->vl_movimento = $vl_dif;
            $hist->save();
            
            $credito = CreditoUsuario::where('id_user',$request->id_user_selecao)->first();
            if ($credito != null){
                $credito->vl_credito += $vl_dif;
                $credito->save();
            }
            else {
                $credito = new CreditoUsuario();
                $credito->id_user = $request->id_user_selecao;
                $credito->vl_credito = $vl_dif;
                $credito->save();
            }
        }
        
        if ($id_quitado){
            event(new JoiaPagaEvent($usuario));
        }
        
        return redirect('usuarios/telaPagamentoSelecao')->with('sucesso', 'Pagamento Realizado com Sucesso!');
    }
    
    public function telaReciboSelecao()
    {
        $usuarios = User::where('id','>',0)
        ->where('cd_pagamento',Pagamento::PAGO)
        ->with('perfil')
        ->with('pagamento')
        ->orderBy('name')->get();
        
        view()->share('usuarios', $usuarios);
        
        return view('usuarios.telaReciboSelecao');
    }
    
    public function imprimirRecibo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user_selecao' => 'required|exists:users,id',
            'submit' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect('usuarios/telaReciboSelecao')
            ->withErrors($validator)
            ->withInput();
        }
        
        if ($request->submit == "imprimir"){
            $recibo = new GeraRecibo($request->id_user_selecao);
            $recibo->gerar(GeraRecibo::METODO_TELA);
        }
        else if ($request->submit == "reenviar"){
            $user = User::where('id',$request->id_user_selecao)->first();
            
            Mail::to($user)->send(new EmailRecibo($user));
            
            return redirect('home')->with('mensagem', 'Recibo Enviado com Sucesso!');
        }
    }
    
    public function telaExclusao(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required:exists:users,id',
        ]);
        
        if ($validator->fails()) {
            return redirect('usuarios/telaManutencaoLista')
            ->withErrors($validator)
            ->withInput();
        }
        
        $usuario = User::where('id',$request->id)
                 ->with('perfil')
                 ->first();
                
        view()->share('usuario_exclusao', $usuario);
        
        return view('usuarios.telaExclusao');
    }
    
    public function excluir(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user_exclusao' => 'required|exists:users,id'            
        ]);
        
        if ($validator->fails()) {
            return redirect('usuarios/telaExclusao?id='.$request->id_user_exclusao)
            ->withErrors($validator)
            ->withInput();
        }

        $avisos = AvisoAposta::where('id_user',$request->id_user_exclusao)->get();
        if (count($avisos) > 0){
            foreach($avisos as $aviso){
                $aviso->delete();                
            }
        }
        
        $usuario = User::where('id',$request->id_user_exclusao)->first();
        
        $usuario->delete();
        
        return redirect('usuarios/telaManutencaoLista')->with('sucesso', 'Usuário Excluído com Sucesso!');
    }
    
    public function telaCriarNotificacao()
    {
        $tb_icones['bell'] = 'Padrão';
        $tb_icones['exclamation-circle'] = 'Atenção';
        $tb_icones['bug'] = 'Problema';
        $tb_icones['calendar-check-o'] = 'Calendário';
        
        view()->share('tb_icones', $tb_icones);
        
        return view('usuarios.telaCriarNotificacao');
    }
    
    public function criarNotificacao(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ds_titulo' => 'required',
            'ds_mensagem' => 'required',
            'ds_icone' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect('usuarios/telaCriarNotificacao')
            ->withErrors($validator)
            ->withInput();
        }
        
        $notificacao = new Notificacao();
        $notificacao->ds_icon = $request->ds_icone;
        $notificacao->ds_cor = 'btn-info';
        $notificacao->ds_numero = '';
        $notificacao->ds_link = '';
        $notificacao->ds_texto = $request->ds_titulo;
        $notificacao->ds_descricao = $request->ds_mensagem;
        $notificacao->tp_notificacao = Notificacao::TIPO_SIMPLES;
        $notificacao->save();
        
        $id_email = false;
        if ($request->id_email){
            $id_email = true;
        }
        
        event(new NotificacaoSimplesEvent($notificacao, $id_email));
        
        return redirect('home')->with('sucesso', 'Notificação Criada com Sucesso!');
    }
    
    public function telaCreditarPontosXP()
    {
        $usuarios = User::orderBy('name')->get();
        $tb_usuarios = array();
        foreach($usuarios as $usuario){
            $tb_usuarios[$usuario->id] = $usuario->name;
        }
        
        view()->share('tb_usuarios',$tb_usuarios);
        
        return view('usuarios.telaCreditarPontosXP');
    }
    
    public function creditarPontosXP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required|exists:users,id',
            'vl_credito' => 'required',
            'ds_observacao' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect('usuarios/telaCreditarPontosXP')
            ->withErrors($validator)
            ->withInput();
        }
        
        $vl_credito = str_replace(',', '.', $request->vl_credito);
        
        $usuario = User::where('id',$request->id_usuario)->first();
        
        $usuario->qt_pontos_xp += $vl_credito;
        $usuario->save();
        
        $hist = new HistoricoPontoXP();
        $hist->id_user = $request->id_usuario;
        $hist->tp_transacao = HistoricoPontoXP::TIPO_ENTRADA;
        $hist->dt_transacao = date('Y-m-d');
        $hist->ds_transacao = $request->ds_observacao;
        $hist->vl_transacao = $vl_credito;
        $hist->save();
        
        return redirect('home')->with('sucesso', 'Pontos Creditados com Sucesso!');
    }
    
    public function telaMural(){
        
        return view('usuarios.telaMural');
    }
    
    public function atualizarMural(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ds_mensagem' => 'required',            
        ]);
        
        if ($validator->fails()) {
            return redirect('usuarios/telaMural')
            ->withErrors($validator)
            ->withInput();
        }
        
        $murais = Mural::all();
        if (count($murais) > 0){
            foreach($murais as $mural){
                $mural->delete();
            }
        }
        
        $mural = new Mural();
        $mural->ds_mensagem = $request->ds_mensagem;
        $mural->id_user = $this->usuario->id;
        $mural->save();
        
        return redirect('home')->with('sucesso', 'Mural Atualizado com Sucesso!');
    }
    
    public function desabilitarMural()
    {
        $murais = Mural::all();
        foreach($murais as $mural){
            $mural->delete();
        }
        
        return redirect('home')->with('sucesso', 'Mural Desabilitado com Sucesso!');
    }
    
    public function telaFiltroPremio(){
        $rankings = TipoRanking::where('cd_status',StatusRanking::FECHADO)->get();
        
        if (count($rankings) == 0){
            return redirect('home')->with('erro', 'Não Há Nenhum Ranking Fechado Ainda para se Pagar Prêmio!');
        }
        
        $tb_rankings = array();
        $id_tem = false;
        foreach($rankings as $ranking){
            $qt_premios = 0;
            if ($ranking->pc_premio1 > 0){
                $qt_premios++;
            }
            if ($ranking->pc_premio2 > 0){
                $qt_premios++;
            }
            if ($ranking->pc_premio3 > 0){
                $qt_premios++;
            }
            $premios = Premio::where('cd_ranking',$ranking->id)->get();
            if (count($premios) < $qt_premios){
            	$tb_rankings[$ranking->id] = $ranking->ds_nome;
            	$id_tem = true;
            }
        }
        
        if ($id_tem == false){
            return redirect('home')->with('sucesso', 'Não há nenhum Ranking a ter Prêmio a ser Pago!');
        }
        
        view()->share('tb_rankings',$tb_rankings);
        return view('usuarios.telaFiltroPremio');
    }
    
    public function telaSelecionarGanhador(Request $request){
        $validator = Validator::make($request->all(), [
            'id_ranking' => 'required|exists:tipos_rankings,id',
        ]);
        
        if ($validator->fails()) {
            return redirect('usuarios/telaFiltroPremio')
            ->withErrors($validator)
            ->withInput();
        }
        
        $tipoRanking = TipoRanking::where('id',$request->id_ranking)->first();
                
        $rankings = Ranking::where('cd_ranking',$request->id_ranking)
        ->with('tipoRanking')
        ->with('usuario')
        ->orderBy('qt_pontos', 'asc')
        ->orderBy('qt_acertos_cheio', 'asc')
        ->orderBy('qt_acertos_parcial', 'asc')
        ->orderBy('qt_acertos_resultado', 'asc')
        ->orderBy('qt_pontos_maior', 'asc')
        ->get();
        
        if (count($rankings) == 0){
            return redirect('usuarios/telaFiltroPremio')->with('erro', 'Não há nenhum ranking gerado ainda para essa fase!');
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
            
            $tb_ranking[] = array('nr_posicao'=>$qt_posicao,
                'ds_nome'=>$ranking->usuario->name,
                'id_user'=>$ranking->usuario->id,
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
                'id_ranking'=>$request->id_ranking                
            );
        }
        
        view()->share('tipoRanking',$tipoRanking);
        view()->share('tb_ranking', $tb_ranking);
        
        return view('usuarios.telaSelecionarGanhador');
    }
    
    public function telaPremioDetalhe(Request $request){
        $validator = Validator::make($request->all(), [
            'id_ranking' => 'required|exists:tipos_rankings,id',
            'id_usuario' => 'required|exists:users,id',
        ]);
        
        if ($validator->fails()) {
            return redirect('usuarios/telaSelecionarGanhador?id_ranking='.$request->id_ranking)
            ->withErrors($validator)
            ->withInput();
        }
        
        $tipoRanking = TipoRanking::where('id',$request->id_ranking)->first();
        $usuario_selecao = User::where('id',$request->id_usuario)->first();
        
        $formas = FormaPagamento::where('id','>',0)
                  ->orderBy('ds_nome')
                  ->get();
        $tb_formas = array();
        foreach($formas as $forma){
            $tb_formas[$forma->id] = $forma->ds_nome;  
        }
        
        $valor_bolao = 0;
        $usuariosPago = User::where('vl_pagamento','>',0)->get();
        foreach($usuariosPago as $usuarioPago){
            $valor_bolao += $usuarioPago->vl_pagamento;
        }
        
        $valor_caixa = $valor_bolao;
        $premios = Premio::where('id','>',0)->get();
        foreach($premios as $premio){
            $valor_caixa = $valor_caixa - $premio->vl_premio;
        }
        
        $id_premio1 = false;
        $id_premio2 = false;
        $id_premio3 = false;
        $vl_premio1 = 0;
        $vl_premio2 = 0;
        $vl_premio3 = 0;
        $pc_premio1 = 0;
        $pc_premio2 = 0;
        $pc_premio3 = 0;
        $tb_posicoes = array();
        if ($tipoRanking->pc_premio1 > 0){
            $id_premio1 = true;
            $tb_posicoes[1] = 'Primeiro Lugar';
            $vl_premio1 = $valor_bolao * ($tipoRanking->pc_premio1 / 100);
            $pc_premio1 = $tipoRanking->pc_premio1;
        }
        if ($tipoRanking->pc_premio2 > 0){
            $id_premio2 = true;
            $tb_posicoes[2] = 'Segundo Lugar';
            $vl_premio2 = $valor_bolao * ($tipoRanking->pc_premio2 / 100);
            $pc_premio2 = $tipoRanking->pc_premio2;
        }
        if ($tipoRanking->pc_premio3 > 0){
            $id_premio3 = true;
            $tb_posicoes[3] = 'Terceiro Lugar';
            $vl_premio3 = $valor_bolao * ($tipoRanking->pc_premio3 / 100);
            $pc_premio3 = $tipoRanking->pc_premio3;
        }
                
        view()->share('tipoRanking',$tipoRanking);
        view()->share('usuario_selecao',$usuario_selecao);
        view()->share('tb_formas',$tb_formas);
        view()->share('valor_bolao',$valor_bolao);
        view()->share('valor_caixa',$valor_caixa);
        view()->share('id_premio1',$id_premio1);
        view()->share('vl_premio1',$vl_premio1);
        view()->share('pc_premio1',$pc_premio1);
        view()->share('id_premio2',$id_premio2);
        view()->share('vl_premio2',$vl_premio2);
        view()->share('pc_premio2',$pc_premio2);
        view()->share('id_premio3',$id_premio3);
        view()->share('vl_premio3',$vl_premio3);
        view()->share('pc_premio3',$pc_premio3);
        view()->share('tb_posicoes', $tb_posicoes);
        
        return view('usuarios.telaPremioDetalhe');
    }
    
    public function pagarPremio(Request $request){
        
        $validator = Validator::make($request->all(), [
            'id_ranking' => 'required|exists:tipos_rankings,id',
            'id_usuario' => 'required|exists:users,id',
            'nr_posicao' => 'required',
            'cd_forma' => 'required|exists:formas_pagamentos,id',
            'dt_pagamento' => 'required|date_format:d/m/Y',
            'hr_pagamento' => 'required|date_format:H:i',
            'vl_premio'=>'required',
            'vl_bolao' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect('usuarios/telaPremioDetalhe?id_ranking='.$request->id_ranking.'&id_usuario='.$request->id_usuario)
            ->withErrors($validator)
            ->withInput();
        }

        $dt_pagamento = Carbon::createFromFormat('d/m/Y',$request->dt_pagamento)->format('Y-m-d');
        $hr_pagamento = $request->hr_pagamento.':00';
        
        $vl_premio = substr($request->vl_premio, 2);
        $vl_premio = str_replace(',', '.', $vl_premio);
        
        $ds_observacao = '';
        if ($request->has('ds_observacao')){
            $ds_observacao = $request->ds_observacao;
        }
        
        $pc_premio = $vl_premio / $request->vl_bolao;
        $pc_premio = number_format($pc_premio,2);
        
        DB::beginTransaction();
        
        $premio = new Premio();
        $premio->id_user = $request->id_usuario;
        $premio->cd_ranking = $request->id_ranking;
        $premio->nr_posicao = $request->nr_posicao;
        $premio->pc_premio = $pc_premio;
        $premio->vl_premio = $vl_premio;
        $premio->cd_pagamento = $request->cd_forma;
        $premio->ds_observacao = $ds_observacao;
        $premio->dt_hr_pagamento = $dt_pagamento.' '.$hr_pagamento;
        $premio->save();

        $usuario = User::where('id',$request->id_usuario)->first();
        $usuario->vl_premio = $usuario->vl_premio + $vl_premio;
        $usuario->save();
        
        DB::commit();
        
        event(new PremioPagoEvent($premio));
        
        return redirect('home')->with('sucesso', 'Prêmio Pago com Sucesso!');
    }
    
    public function telaCriarVotacao(){
        $tb_qtd[0] = 'Selecione';
        $tb_qtd[1] = '1 Valor';
        $tb_qtd[2] = '2 Valores';
        $tb_qtd[3] = '3 Valores';
        $tb_qtd[4] = '4 Valores';
        $tb_qtd[5] = '5 Valores';
        
        view()->share('tb_qtd',$tb_qtd);
        
        return view('usuarios.telaCriarVotacao');
    }
    
    public function incluirVotacao(Request $request){
        
        $validator = Validator::make($request->all(), [
            'ds_titulo' => 'required',
            'ds_descricao' => 'required',
            'qt_valores' => 'required|max:5'            
        ]);
        
        if ($validator->fails()) {
            return redirect('usuarios/telaCriarVotacao')
            ->withErrors($validator)
            ->withInput();
        }
        
        DB::beginTransaction();
        
        $votacao = new Pool();
        $votacao->ds_titulo = trim($request->ds_titulo);
        $votacao->ds_descricao = trim($request->ds_descricao);
        $votacao->save();
        
        for($i=1;$i<=$request->qt_valores;$i++){
            $valor = new PoolValor();
            $valor->id_pool = $votacao->id;
            $valor->cd_valor = $request->{'vl_voto'.$i};
            $valor->ds_valor = $request->{'ds_voto'.$i};
            $valor->save();
        }
        
        DB::commit();
        
        return redirect('home')->with('sucesso', 'Votação Incluída com Sucesso!');
    }
    
    public function votar(Request $request){
        
        $validator = Validator::make($request->all(), [
            'qt_votacoes' => 'required',            
        ]);
        
        if ($validator->fails()) {
            return redirect('home')
            ->withErrors($validator)
            ->withInput();
        }
        
        for($i=1;$i<=$request->qt_votacoes;$i++){
            $id_votacao = $request->{'id_votacao_'.$i};
            $votacao = Pool::where('id',$id_votacao)->first();
            
            if ($votacao == null){
                return redirect('home')->with('erro', 'Votação Não Localizada!');
            }
            
            $voto = PoolVoto::where('id_pool',$id_votacao)
                    ->where('id_user',$this->usuario->id)
                    ->first();
            
            if ($voto != null){
                $voto->cd_valor = $request->{'cd_voto_'.$i};
                $voto->save();
            }
            else {
                $voto = new PoolVoto();
                $voto->id_pool = $id_votacao;
                $voto->id_user = $this->usuario->id;
                $voto->cd_valor = $request->{'cd_voto_'.$i};
                $voto->save();
            }
        }
        
        return redirect('home')->with('sucesso', 'Votação Realizada com Sucesso!');
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
        
        return view('usuarios.telaListaVotacoes');
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
        
        return view('usuarios.detalharVotacao');
    }
}
