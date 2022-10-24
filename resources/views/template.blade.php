<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>@yield('titulo')</title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
		 
		 <!-- 
		<script defer src="{{ asset('assets/font-awesome/5.0.10/js/fontawesome-all.js') }}"></script>
		<script defer src="{{ asset('assets/font-awesome/5.0.10/js/fa-v4-shims.js') }}"></script>
		-->
		
		
		<link rel="stylesheet" href="{{ asset('assets/font-awesome/4.7.0/css/font-awesome.min.css') }}" />
			

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="{{ asset('assets/css/fonts.googleapis.com.css') }}" />

		<!-- ace styles -->
		<link rel="stylesheet" href="{{ asset('assets/css/ace.min.css') }}" class="ace-main-stylesheet" id="main-ace-style" />

		<!--  customs page -->
		@yield('header_css')

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="{{ asset('assets/css/ace-part2.min.css" class="ace-main-stylesheet') }}" />
		<![endif]-->
		<link rel="stylesheet" href="{{ asset('assets/css/ace-skins.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/css/ace-rtl.min.css') }}" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="{{ asset('assets/css/ace-ie.min.css') }}" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="{{ asset('assets/js/ace-extra.min.js') }}"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="{{ asset('assets/js/html5shiv.min.js') }}"></script>
		<script src="{{ asset('assets/js/respond.min.js') }}"></script>
		<![endif]-->
	</head>

	<body class="{{env('CLASS_BODY_TEMPLATE','no-skin')}}">
		<div id="navbar" class="navbar navbar-default          ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="/home" class="navbar-brand">
						<small>
							<i class="fa fa-futbol-o"></i>
							{{ config('app.name') }}
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="grey dropdown-modal">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-tasks"></i>
								<span class="badge badge-grey">@if ($id_tarefas) {{$tarefas->qt_tarefas}} @else 0 @endif</span>
							</a>
							<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-check"></i>
									@if ($id_tarefas)
										@if ($tarefas->id_tarefas)
										Você tem {{$tarefas->qt_tarefas}} pendência(s)
										@else
										Sem pendências no momento
										@endif
									@else 
										Sem pendências no momento
									@endif
								</li>

								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar">
									@if ($id_tarefas)
									@if ($tarefas->id_pgto_pendente)
									<li><a href="#">
											<div class="clearfix">
												<span class="pull-left">Pagamento Jóia</span> <span
													class="pull-right">R${{number_format($tarefas->vl_pago,2,',','')}}/R${{number_format(\App\Models\User::VALOR_JOIA_PREMIO,2,',','')}}</span>
											</div>

											<div class="progress progress-mini">
												<div style="width: {{$tarefas->pc_pagto}}%"
													class="progress-bar"></div>
											</div>
									</a></li> @endif @if ($tarefas->id_aposta_pendente)
									<li><a href="#">
											<div class="clearfix">
												<span class="pull-left">Palpites Feitos</span> <span
													class="pull-right">{{$tarefas->qt_apostas}}/{{$tarefas->qt_jogos}}</span>
											</div>

											<div class="progress progress-mini">
												<div style="width: {{$tarefas->pc_apostas}}%"
													class="progress-bar progress-bar-danger"></div>
											</div>
									</a></li> @endif
									@endif

								</ul>
								</li>

								
							</ul>
						</li>

						<li class="purple dropdown-modal">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-bell icon-animated-bell"></i>
								<span class="badge badge-important">{{($qt_notificacoes + $qt_notificacoes_album)}}</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-exclamation-triangle"></i>
									{{($qt_notificacoes + $qt_notificacoes_album)}} Notificações
								</li>

								@if ($qt_notificacoes > 0 || $qt_notificacoes_album > 0)
								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar navbar-pink">
										@if (isset($notificacoes))
										@foreach($notificacoes as $notificacao)
										<li>
											@if ($notificacao->tp_notificacao == \App\Models\Notificacao::TIPO_SIMPLES)
											<a href="{{url('notificacoes/telaConsultaNotSimples')}}?id_notificacao={{$notificacao->id}}">
											@elseif ($notificacao->tp_notificacao == \App\Models\Notificacao::TIPO_PESOS_TIMES)
											<a href="{{url('notificacoes/telaConsultaNotPesosTimes')}}?id_notificacao={{$notificacao->id}}">
											@else
											<a href="#">
											@endif
												<div class="clearfix">
													<span class="pull-left">
														<i class="btn btn-xs no-hover btn-{{$notificacao->ds_cor}} fa fa-{{$notificacao->ds_icon}}"></i>
														{{$notificacao->ds_texto}}
													</span>
													@if ($notificacao->ds_numero != "")
													<span class="pull-right badge badge-info">{{$notificacao->ds_numero}}</span>
													@endif
												</div>
											</a>
										</li>
										@endforeach
										@endif
										@if (isset($notificacoesAlbum))
										@foreach($notificacoesAlbum as $notificacao)
										<li>
											@if ($notificacao->tp_notificacao == \App\Models\NotificacaoAlbum::TIPO_NOTIFICACAO_OFERTA)
												@if ($notificacao->tp_resposta == \App\Models\NotificacaoAlbum::TIPO_RESPOSTA_ENVIADO)
												<a href="{{url('figurinhas/telaPropostaRecebidaDetalhe')}}?_token={{ csrf_token() }}&id_proposta={{$notificacao->id_transacao}}">
												@else
												<a href="{{url('figurinhas/telaVerMinhasOfertas')}}">
												@endif											
											@endif
												<div class="clearfix">
													<span class="pull-left">
														<i class="btn btn-xs no-hover @if ($notificacao->tp_resposta == \App\Models\NotificacaoAlbum::TIPO_RESPOSTA_REJEITADO) btn-danger @else btn-primary @endif fa  @if ($notificacao->tp_resposta == \App\Models\NotificacaoAlbum::TIPO_RESPOSTA_ENVIADO) fa-arrow-right @elseif ($notificacao->tp_resposta == \App\Models\NotificacaoAlbum::TIPO_RESPOSTA_APROVADO) fa-check @elseif ($notificacao->tp_resposta == \App\Models\NotificacaoAlbum::TIPO_RESPOSTA_REJEITADO) fa-times @elseif ($notificacao->tp_resposta == \App\Models\NotificacaoAlbum::TIPO_RESPOSTA_CANCELADO) fa-ban @endif"></i>
														{{$notificacao->ds_observacao}}
													</span>													
												</div>
											</a>
										</li>
										@endforeach
										@endif
									</ul>
								</li>

								<li class="dropdown-footer">
									<a href="{{url('notificacoes/consultarListaNotificacoes')}}">
										Ver Todas Notificações
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
								@endif
							</ul>
						</li>

						<li class="green dropdown-modal">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
								<span class="badge badge-success">{{$qt_mensagens}}</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-envelope-o"></i>
									{{$qt_mensagens}} Mensagens
								</li>

								@if ($qt_mensagens > 0)
								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar">
										@foreach($mensagens as $mensagem)
										<li>
											<a href="{{url('mensagens\telaVerMensagem')}}?id_mensagem={{$mensagem->id}}" class="clearfix">																												
												@if (\App\Funcoes\VerificaAvatar::verificar($mensagem->mensagem->id_user_from))
                								<img class="msg-photo" src="data:image/png;base64,{{ base64_encode(Storage::get('avatars/'.$mensagem->mensagem->id_user_from))}}" alt="Photo" />
                								@else
                								<img class="msg-photo" src="{{ asset('assets/images/avatars/user.jpg') }}" alt="Photo" />                                								
                								@endif												
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">{{$mensagem->mensagem->usuarioDe->name}}:</span>
														@if (strlen($mensagem->mensagem->ds_titulo) <= 20)
														{{$mensagem->mensagem->ds_titulo}}
														@else
														{{substr($mensagem->mensagem->ds_titulo,0,20)}}...
														@endif
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>{{substr($mensagem->mensagem->updated_at,11,5)}}</span>
													</span>
												</span>
											</a>
										</li>
										@endforeach
									</ul>
								</li>

								<li class="dropdown-footer">
									<a href="{{url('mensagens/telaConsultarMensagens')}}">
										Ver Todas as Mensagens
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
								@endif
							</ul>
						</li>
						
						<li class="light-blue dropdown-modal">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								@if ($id_avatar == 'S')
								<img class="nav-user-photo" src="{{ $img_avatar }}" alt="Photo" />
								@else
								<img class="nav-user-photo" src="{{ asset('assets/images/avatars/user.jpg') }}" alt="Photo" />
								@endif								
								<span class="user-info">
									<small>Bem vindo,</small>
									{{ Auth::user()->name }}
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

								<li>
									<a href="{{ url('perfil') }}">
										<i class="ace-icon fa fa-user"></i>
										Perfil
									</a>
								</li>
								
								<li>
									<a href="{{ url('trofeus') }}">
										<i class="ace-icon fa fa-trophy"></i>
										Troféus
									</a>
								</li>
								
								<li>
									<a href="{{ url('notificacoes/consultarListaNotificacoes') }}">
										<i class="ace-icon fa fa-bell"></i>
										Notificações
									</a>
								</li>
								
								<li>
									<a href="{{ url('figurinhas/verAlbum') }}">
										<i class="ace-icon fa fa-book"></i>
										Album
									</a>
								</li>
								
								<li>
									<a href="{{ url('pontosXP/resumoUsuario') }}">
										<i class="ace-icon fa fa-money"></i>
										Brothetas
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
										<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    	</form>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				<ul class="nav nav-list">
					<li class="active">
						<a href="{{ url('home') }}">
							<i class="menu-icon fa fa-home"></i>
							<span class="menu-text"> Início </span>
						</a>

						<b class="arrow"></b>
					</li>
					
					<li>
						<a href="{{ url('regulamento') }}">
							<i class="menu-icon fa fa-book"></i>
							<span class="menu-text"> Regulamento </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-money"></i>
							<span class="menu-text">
								Palpites
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="">
								<a href="{{ url('apostas/telaEditar') }}">
									<i class="menu-icon fa fa-edit"></i>
									Editar
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="{{ url('apostas/telaMinhaConsultaLista') }}?cd_ranking={{env('CLASSIFICACAO_GERAL','1')}}&cd_status={{\App\Http\Controllers\Apostas\ApostasController::COD_COMBO_STATUS_TODOS}}">
									<i class="menu-icon fa fa-search"></i>
									Meus Palpites
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="{{ url('apostas/telaConsultaGeralLista') }}">
									<i class="menu-icon fa fa-search"></i>
									Palpites Gerais
								</a>

								<b class="arrow"></b>
							</li>
							
						</ul>
					</li>

					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-line-chart"></i>
							<span class="menu-text"> Ranking </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="{{ url('rankings/telaFiltroConsulta') }}">
									<i class="menu-icon fa fa-search"></i>
									Consultar
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
						
						<ul class="submenu">
							<li class="">
								<a href="{{ url('rankings/telaFiltroInforme') }}">
									<i class="menu-icon fa fa-print"></i>
									Gerar Informe
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
						
						<ul class="submenu">
							<li class="">
								<a href="{{ url('rankings/telaFiltroFechamento') }}">
									<i class="menu-icon fa fa-print"></i>
									Gerar Fechamento
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
						
						<ul class="submenu">
							<li class="">
								<a href="{{ url('rankings/telaFiltroCertificado') }}">
									<i class="menu-icon fa fa-print"></i>
									Gerar Certificado
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>
	
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-trophy"></i>
							<span class="menu-text"> Jogos </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="{{ url('jogos/telaIncluir') }}">
									<i class="menu-icon fa fa-plus-square"></i>
									Incluir
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="{{ url('jogos/telaManutencaoLista') }}">
									<i class="menu-icon fa fa-edit"></i>
									Manutenção
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="{{ url('jogos/telaResultados') }}">
									<i class="menu-icon fa fa-star-half-o"></i>
									Resultados
								</a>

								<b class="arrow"></b>
							</li>
														
							<li class="">
								<a href="{{ url('jogos/telaConsultarLista') }}">
									<i class="menu-icon fa fa-search"></i>
									Consultar
								</a>

								<b class="arrow"></b>
							</li>
							
						</ul>
					</li>
					
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-id-card"></i>
							<span class="menu-text"> Figurinhas </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="{{ url('figurinhas/telaCompra') }}">
									<i class="menu-icon fa fa-cart-plus"></i>
									Comprar
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="{{ url('figurinhas/telaListarMinhas') }}">
									<i class="menu-icon fa fa-cart-plus"></i>
									Minhas Figurinhas
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="{{ url('figurinhas/telaListarRepetidas') }}">
									<i class="menu-icon fa fa-clone"></i>
									Repetidas
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="{{ url('figurinhas/telaResumo') }}">
									<i class="menu-icon fa fa-pie-chart"></i>
									Resumo Coleção
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="#" class="dropdown-toggle">
									<i class="menu-icon fa fa-shopping-basket orange"></i>

									Ofertas
									<b class="arrow fa fa-angle-down"></b>
								</a>

								<b class="arrow"></b>

								<ul class="submenu">
									<li class="">
										<a href="{{ url('figurinhas/telaProcurarPropostas') }}">
											<i class="menu-icon fa fa-search orange"></i>
											Procurar Propostas
										</a>

										<b class="arrow"></b>
									</li>
									
									<li class="">
										<a href="{{ url('figurinhas/telaCancelarOferta') }}">
											<i class="menu-icon fa fa-ban orange"></i>
											Cancelar Oferta
										</a>

										<b class="arrow"></b>
									</li>
									
									<li class="">
										<a href="{{ url('figurinhas/telaVerMinhasOfertas') }}">
											<i class="menu-icon fa fa-eye orange"></i>
											Ver Meus Lances
										</a>

										<b class="arrow"></b>
									</li>
								</ul>
							</li>
							
							<li class="">
								<a href="#" class="dropdown-toggle">
									<i class="menu-icon fa fa-shopping-cart green"></i>

									Propostas
									<b class="arrow fa fa-angle-down"></b>
								</a>

								<b class="arrow"></b>

								<ul class="submenu">
									<li class="">
										<a href="{{ url('figurinhas/telaOferecerFigurinha') }}">
											<i class="menu-icon fa fa-hand-paper-o green"></i>
											Oferecer Figurinha
										</a>

										<b class="arrow"></b>
									</li>

									<li class="">
										<a href="{{ url('figurinhas/telaPropostasRecebidas') }}">
											<i class="menu-icon fa fa-inbox green"></i>
											Propostas com Ofertas
										</a>

										<b class="arrow"></b>
									</li>
									
									<li class="">
										<a href="{{ url('figurinhas/telaEncerrarProposta') }}">
											<i class="menu-icon fa fa-ban green"></i>
											Encerrar Proposta
										</a>

										<b class="arrow"></b>
									</li>
									
									<li class="">
										<a href="{{ url('figurinhas/telaVerMinhasPropostas') }}">
											<i class="menu-icon fa fa-eye green"></i>
											Ver Minhas Propostas 
										</a>

										<b class="arrow"></b>
									</li>
								</ul>
							</li>
							
						</ul>
					</li>
					
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-thumbs-up"></i>
							<span class="menu-text"> Votações </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="{{ url('votacoes/telaListaVotacoes') }}">
									<i class="menu-icon fa fa-search"></i>
									Consultar
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-envelope"></i>
							<span class="menu-text"> Mensagens </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="{{ url('mensagens/telaNovaMensagem') }}">
									<i class="menu-icon fa fa-edit"></i>
									Enviar Mensagem
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="{{ url('mensagens/telaConsultarMensagens') }}">
									<i class="menu-icon fa fa-search"></i>
									Ver Minhas Mensagens
								</a>

								<b class="arrow"></b>
							</li>
							
						</ul>
					</li>
					
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-globe"></i>
							<span class="menu-text"> Times </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="{{ url('selecoes/telaManutencao') }}">
									<i class="menu-icon fa fa-edit"></i>
									Manutenção
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="{{ url('selecoes/telaConsulta') }}">
									<i class="menu-icon fa fa-search"></i>
									Consultar
								</a>

								<b class="arrow"></b>
							</li>
							
						</ul>
					</li>
					
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-th-list"></i>
							<span class="menu-text"> Tipos de Ranking </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="{{ url('tiposRankings/telaIncluir') }}">
									<i class="menu-icon fa fa-plus-square"></i>
									Incluir
								</a>

								<b class="arrow"></b>
							</li>
							
						</ul>
						
						<ul class="submenu">
							<li class="">
								<a href="{{ url('tiposRankings/telaManutencaoLista') }}">
									<i class="menu-icon fa fa-edit"></i>
									Manutenção
								</a>

								<b class="arrow"></b>
							</li>
							
						</ul>
					</li>

					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> Usuários </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="{{ url('usuarios/telaIncluir') }}">
									<i class="menu-icon fa fa-plus-square"></i>
									Incluir
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="{{ url('usuarios/telaManutencaoLista') }}">
									<i class="menu-icon fa fa-edit"></i>
									Manutenção
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="{{ url('usuarios/consultarLista') }}">
									<i class="menu-icon fa fa-search"></i>
									Consultar
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="{{ url('usuarios/telaPagamentoSelecao') }}">
									<i class="menu-icon fa fa-money"></i>
									Pagamento
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="{{ url('usuarios/telaReciboSelecao') }}">
									<i class="menu-icon fa fa-file"></i>
									Recibo
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="#" class="dropdown-toggle">
									<i class="menu-icon fa fa-bell"></i>

									Notificação
									<b class="arrow fa fa-angle-down"></b>
								</a>

								<b class="arrow"></b>

								<ul class="submenu">
									<li class="">
										<a href="{{ url('usuarios/telaCriarNotificacao') }}">
											<i class="menu-icon fa fa-file-text-o"></i>
											Simples
										</a>

										<b class="arrow"></b>
									</li>
									
									<li class="">
										<a href="{{ url('usuarios/telaCriarNotPesosTimes') }}">
											<i class="menu-icon fa fa-bar-chart"></i>
											Pesos Times
										</a>

										<b class="arrow"></b>
									</li>
									
								</ul>
							</li>
							
							<li class="">
								<a href="#" class="dropdown-toggle">
									<i class="menu-icon fa fa-money"></i>

									Brothetas
									<b class="arrow fa fa-angle-down"></b>
								</a>

								<b class="arrow"></b>

								<ul class="submenu">
									<li class="">
										<a href="{{ url('usuarios/telaCreditarPontosXP') }}">
											<i class="menu-icon fa fa-plus"></i>
											Creditar
										</a>

										<b class="arrow"></b>
									</li>
									
									<li class="">
										<a href="{{ url('usuarios/telaConsultarPontosXP') }}">
											<i class="menu-icon fa fa-search"></i>
											Consultar
										</a>

										<b class="arrow"></b>
									</li>
									
								</ul>
							</li>
							
							<li class="">
								<a href="#" class="dropdown-toggle">
									<i class="menu-icon fa fa-flag-checkered"></i>

									Premios
									<b class="arrow fa fa-angle-down"></b>
								</a>

								<b class="arrow"></b>

								<ul class="submenu">
									<li class="">
										<a href="{{ url('usuarios/telaFiltroPremio') }}">
											<i class="menu-icon fa fa-credit-card"></i>
											Realizar Pagamento
										</a>

										<b class="arrow"></b>
									</li>
									
									<li class="">
										<a href="{{ url('usuarios/telaConsultarPremios') }}">
											<i class="menu-icon fa fa-search"></i>
											Consultar
										</a>

										<b class="arrow"></b>
									</li>
									
								</ul>
							</li>

							<li class="">
								<a href="#" class="dropdown-toggle">
									<i class="menu-icon fa fa-file-text-o"></i>
									Mural
									<b class="arrow fa fa-angle-down"></b>
								</a>

								<b class="arrow"></b>

								<ul class="submenu">
									<li class="">
										<a href="{{ url('usuarios/telaMural') }}">
											<i class="menu-icon fa fa-plus"></i>
											Incluir
										</a>

										<b class="arrow"></b>
									</li>
									
									<li class="">
										<a href="{{ url('usuarios/desabilitarMural') }}">
											<i class="menu-icon fa fa-power-off"></i>
											Desabilitar
										</a>

										<b class="arrow"></b>
									</li>
									
								</ul>
							</li>
							
							<li class="">
								<a href="#" class="dropdown-toggle">
									<i class="menu-icon fa fa-thumbs-up"></i>
									Votação
									<b class="arrow fa fa-angle-down"></b>
								</a>

								<b class="arrow"></b>

								<ul class="submenu">
									<li class="">
										<a href="{{ url('usuarios/telaCriarVotacao') }}">
											<i class="menu-icon fa fa-plus"></i>
											Criar
										</a>

										<b class="arrow"></b>
									</li>
									
								</ul>
								
								<ul class="submenu">
									<li class="">
										<a href="{{ url('usuarios/telaListaVotacoes') }}">
											<i class="menu-icon fa fa-search"></i>
											Consultar
										</a>

										<b class="arrow"></b>
									</li>
									
								</ul>
							</li>
							
						</ul>
					</li>
					
				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fas fa-angle-double-left ace-save-state" data-icon1="ace-icon fas fa-angle-double-left" data-icon2="ace-icon fas fa-angle-double-right"></i>
				</div>
			</div>

			@yield('content')

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
						    &copy;
							<span class="blue bolder">Macako Software</span>							
						</span>
					</div>
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="{{ asset('assets/js/jquery-2.1.4.min.js') }}"></script>

		<!-- <![endif]-->

		<!--[if IE]>
        <script src="{{ asset('assets/js/jquery-1.11.3.min.js') }}"></script>
        <![endif]-->
        
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='{{ asset('assets/js/jquery.mobile.custom.min.js') }}'>"+"<"+"/script>");
		</script>
		<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="{{ asset('assets/js/excanvas.min.js') }}"></script>
		<![endif]-->
		<script src="{{ asset('assets/js/jquery-ui.custom.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.ui.touch-punch.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.easypiechart.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.sparkline.index.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.flot.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.flot.pie.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.flot.resize.min.js') }}"></script>

		<!--  -->
		<script src="{{ asset('assets/js/wizard.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.validate.pt-br.js') }}"></script>
		<script src="{{ asset('assets/js/jquery-additional-methods.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootbox.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.maskedinput.min.js') }}"></script>
		<script src="{{ asset('assets/js/select2.min.js') }}"></script>
		

		<!-- ace scripts -->
		<script src="{{ asset('assets/js/ace-elements.min.js') }}"></script>
		<script src="{{ asset('assets/js/ace.min.js') }}"></script>

		<!-- inline scripts related to this page -->
		@yield('pos_script')
	</body>
</html>

