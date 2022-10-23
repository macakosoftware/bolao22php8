@extends('template')

@section('titulo'){{ config('app.name') }} - Início @endsection

@section('header_css')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}" /> 
@endsection

@section('content')
			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="menu-icon fa fa-home home-icon"></i>
								Início								
							</li>							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								INÍCIO
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Estatísticas Gerais
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							@if (!$id_autorizado)
                                <div class="alert alert-danger">
									<button class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>
									<ul>                                        
                                        <li>
										<i class="ace-icon fa fa-exclamation-circle"></i>
										Usuário Não Possui Autoridade para Acessar Essa Opção!									                                            
                                        </li>
                                    </ul>
								</div>
                            @endif
                            
							@if ($errors->any())                              
                                <div class="alert alert-danger">
									<button class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>
									<ul>
                                        @foreach ($errors->all() as $error)
                                            <li>
											<i class="ace-icon fa fa-exclamation-circle"></i>									                                            
                                            {{ $error }}</li>
                                        @endforeach
                                    </ul>
								</div>
                            @endif
                            
                            @if (session('mensagem'))
                            	<div class="alert alert-info">
									<button class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>
									<ul>                                        
                                        <li>
										<i class="ace-icon fa fa-info"></i>									                                            
                                        {{ session('mensagem') }}</li>
                                    </ul>
								</div>
        					@endif
        					
                            @if (session('sucesso'))
                            	<div class="alert alert-success">
									<button class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>
									<ul>                                        
                                        <li>
										<i class="ace-icon fa fa-check-square"></i>									                                            
                                        {{ session('sucesso') }}</li>
                                    </ul>
								</div>
        					@endif
        					
                            @if (session('erro'))
                            	<div class="alert alert-danger">
									<button class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>
									<ul>                                        
                                        <li>
										<i class="ace-icon fa fa-check-square"></i>									                                            
                                        {{ session('erro') }}</li>
                                    </ul>
								</div>
        					@endif
        					
        					@if ($id_mural_comum == 'S')
        					<div id="dialog-message" class="hide">
								{!! $ds_mural_comum !!}							
							</div>
							@endif
							
        					@if ($qt_votacoes > 0)
        					<div id="dialog-votacao" class="hide">
        						<form class="form-horizontal" role="form" id="formVotacao" name="formVotacao" method="POST" action="{{ route('usuarios.votar') }}">
        						{{ csrf_field() }}
        						<input type="hidden" name="qt_votacoes" id="qt_votacoes" value="{{$qt_votacoes}}" />  
								@foreach($tb_votacoes as $votacao)
								<input type="hidden" name="id_votacao_{{$votacao['nr']}}" value="{{$votacao['votacao']->id}}" />
								<h3>{{$votacao['nr']}}) {{$votacao['votacao']->ds_titulo}}</h3>
								<p>{{$votacao['votacao']->ds_descricao}}</p>
								@foreach($votacao['valores'] as $valor)
								<input type="radio" name="cd_voto_{{$votacao['nr']}}" id="cd_voto_{{$votacao['nr']}}_{{$valor->cd_valor}}" value="{{$valor->cd_valor}}" />
								{{$valor->ds_valor}}<br/>
								@endforeach
								@endforeach
								</form>							
							</div>
							@endif
        					
							<div class="col-xs-12">
								
								<div class="row">
									<div class="space-6"></div>

									<div class="col-sm-12 infobox-container">
										<div class="infobox infobox-blue">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-users"></i>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number">{{$nr_usuarios}}</span>
												<div class="infobox-content">Usuários</div>
											</div>
										</div>
										
										<div class="infobox infobox-green">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-trophy"></i>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number">{{$nr_jogos_programados}}</span>
												<div class="infobox-content">Jogos Programados</div>
											</div>

											
										</div>

										<div class="infobox infobox-pink">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-money"></i>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number">{{$qt_apostas_feitas}}</span>
												<div class="infobox-content">Palpites Realizados</div>
											</div>											
										</div>

										<div class="infobox infobox-blue2">
											<div class="infobox-progress">
												<div class="easy-pie-chart percentage" data-percent="{{$pc_apostas_feitas}}" data-size="46">
													<span class="percent">{{number_format($pc_apostas_feitas, 0, ',', '')}}</span>%
												</div>
											</div>

											<div class="infobox-data">
												<span class="infobox-text">Palpites</span>

												<div class="infobox-content">
													<span class="bigger-110">~</span>
													{{$qt_apostas_pendentes}} pendentes
												</div>
											</div>
										</div>

										<div class="space-6"></div>
										
										<div class="infobox infobox-orange infobox-big infobox-dark">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-balance-scale"></i>
											</div>
											
											<div class="infobox-data">
												<div class="infobox-content">Rateio Prêmios</div>
												<div class="infobox-content">{{number_format($vl_para_premios, 2, ',', '.')}}</div>
											</div>
										</div>

										<div class="infobox infobox-grey infobox-big infobox-dark">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-credit-card-alt"></i>
											</div>

											<div class="infobox-data">
												<div class="infobox-content">Prêmios Pagos</div>
												<div class="infobox-content">{{number_format($vl_premios_pagos, 2, ',', '.')}}</div>
											</div>
										</div>
									</div>

									
									<div class="vspace-12-sm"></div>


								</div><!-- /.row -->
								
								<div class="hr hr32 hr-dotted"></div>

								<div class="row">
									
									<div class="col-sm-6">
										<div class="widget-box">
											<div class="widget-header">
												<h4 class="widget-title lighter smaller">
													<i class="ace-icon fa fa-comment blue"></i>
													Mural de Conversas
												</h4>
											</div>
										
											
											<div class="widget-body">
												<div class="widget-main no-padding">
													@if ($id_msg_mural)
													<div class="dialogs">
														@foreach($mensagens_mural as $msg_mural)
														<div class="itemdiv dialogdiv">
															<div class="user">
																@if (\App\Funcoes\VerificaAvatar::verificar($msg_mural->usuario->id))
                                								<img width="50px" height="50px" src="data:image/png;base64,{{ base64_encode(Storage::get('avatars/'.$msg_mural->usuario->id))}}" alt="Photo" />
                                								@else
                                								<img width="50px" height="50px" src="{{ asset('assets/images/avatars/user.jpg') }}" alt="Photo" />                                								
                                								@endif	
															</div>

															<div class="body">
																<div class="time">
																	<i class="ace-icon fa fa-clock-o"></i>
																	<span class="green">{{\Carbon\Carbon::parse($msg_mural->updated_at)->format('d/m/Y H:i:s')}}</span>
																</div>

																<div class="name">
																	<a href="#">{{$msg_mural->usuario->name}}</a>
																</div>
																<div class="text">{{$msg_mural->ds_mensagem}}</div>

																<div class="tools">
																	<a href="#" class="btn btn-minier btn-info">
																		<i class="icon-only ace-icon fa fa-share"></i>
																	</a>
																</div>
															</div>
														</div>
														@endforeach
														
													</div>
													@endif
													<form id="formMural"
													name="formMural" method="POST"
													action="{{ route('mural.postar') }}">
														{{ csrf_field() }}
														<div class="form-actions">
															<div class="input-group">
																<input placeholder="Deixe sua mensagem aqui ..." type="text" class="form-control" name="ds_msg_mural" />
																<span class="input-group-btn">
																	<button class="btn btn-sm btn-info no-radius" type="submit">
																		<i class="ace-icon fa fa-share"></i>
																		Postar
																	</button>
																</span>
															</div>
														</div>
													</form>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->											
										</div><!-- /.widget-box -->
									</div><!-- /.col -->
									<div class="col-sm-6">
										@if ($id_ranking)
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-star orange"></i>
													Ranking Geral (Top 5)
												</h4>

												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main no-padding">
													<table class="table table-bordered table-striped">
														<thead class="thin-border-bottom">
															<tr>
                        										<th>#</th>
                        										<th>Nome</th>
                        										<th>Apostas</th>
                        										<th>Pontos</th>                        										
                        										<th></th>																													
                        									</tr>
														</thead>

														<tbody>
															@foreach($tb_ranking as $ranking)
															<tr>
                        										<td>{{$ranking['nr_posicao']}}</td>
                        										<td>
                        										@if (\App\Funcoes\VerificaAvatar::verificar($ranking['id_user']))
                                								<img width="50px" height="50px" src="data:image/png;base64,{{ base64_encode(Storage::get('avatars/'.$ranking['id_user']))}}" alt="Photo" />
                                								@else
                                								<img width="50px" height="50px" src="{{ asset('assets/images/avatars/user.jpg') }}" alt="Photo" />
                                								@endif	
                                								{{$ranking['ds_nome']}}
                                								@if ($ranking['id_sobe'])
                                								<div class="badge badge-success">
                        										{{$ranking['dif']}}
                        										<i class="ace-icon fa fa-arrow-up"></i>
                        										</div>
                                								@elseif ($ranking['id_desce'])
                                								<div class="badge badge-danger">
                        										{{$ranking['dif']}}
                        										<i class="ace-icon fa fa-arrow-down"></i>
                        										</div>        								
                                								@endif
                        										</td>
                        										<td>{{$ranking['qt_apostas']}}</td>
                        										<td>{{$ranking['qt_pontos']}}</td>                        										
                        										<td>
                        											<div class="hidden-sm hidden-xs action-buttons">
                        												<a class="blue" href="{{ url('apostas/telaDetalhePalpite') }}?id_usuario={{$ranking['id_user']}}&cd_status={{App\Http\Controllers\Apostas\ApostasController::COD_COMBO_STATUS_TODOS}}&cd_ranking={{$ranking['id_ranking']}}">
                        													<i class="ace-icon fa fa-search-plus bigger-130"></i>
                        												</a>
                        											</div>
                        											<div class="hidden-md hidden-lg">
                        												<div class="inline pos-rel">
                        													<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                        														<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                        													</button>
                        
                        													<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                        														<li>
                        															<a href="{{ url('apostas/telaDetalhePalpite') }}?id_usuario={{$ranking['id_user']}}}&cd_status={{App\Http\Controllers\Apostas\ApostasController::COD_COMBO_STATUS_TODOS}}&cd_ranking={{$ranking['id_ranking']}}" class="tooltip-info" data-rel="tooltip" title="Detalhar">
                        																<span class="blue">
                        																	<i class="ace-icon fa fa-search-plus bigger-120"></i>
                        																</span>
                        															</a>
                        														</li>														
                        													</ul>
                        												</div>
                        											</div>
                        											
                        										</td>
                        									</tr>							
                        									@endforeach													
														</tbody>
													</table>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
										@else
										O Ranking Geral ainda não foi publicado
										@endif
									</div>
								</div><!-- /.row -->

								<div class="hr hr32 hr-dotted"></div>

								<div class="row">
									<div class="col-sm-12">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-star orange"></i>
													Próximos Jogos
												</h4>

												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main no-padding">
													<table class="table table-bordered table-striped">
														<thead class="thin-border-bottom">
															<tr>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Seleção 1
																</th>
			
																<th>X</th>
																
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Seleção 2
																</th>

																<th class="hidden-480">
																	<i class="ace-icon fa fa-caret-right blue"></i>Data/Hora
																</th>
																
																<th class="hidden-480">
																	<i class="ace-icon fa fa-caret-right blue"></i>Status
																</th>
															</tr>
														</thead>

														<tbody>
															@foreach($tb_jogos as $jogo)
															<tr>
																<td>
																<img src="{{ asset('images/brasoes') }}/{{$jogo->selecao1->ds_icone}}" />
																{{$jogo->selecao1->ds_nome}} 												
																</td>
																<td>X</td>
																<td>			
																<img src="{{ asset('images/brasoes') }}/{{$jogo->selecao2->ds_icone}}" />
																{{$jogo->selecao2->ds_nome}}
																</td>
																<td>
																{{ \Carbon\Carbon::parse($jogo->dt_jogo)->format('d/m/Y')}} - {{substr($jogo->hr_jogo, 0, 5)}}
																</td>
																<td>
																@if ($jogo->cd_status == \App\Models\StatusJogo::JOGO_PROGRAMADO)
																<span class="label label-info arrowed-right arrowed-in">
																@endif
																@if ($jogo->cd_status == \App\Models\StatusJogo::JOGO_APOSTA_ENCERRADA)
																<span class="label label-warning arrowed arrowed-right">
																@endif
																@if ($jogo->cd_status == \App\Models\StatusJogo::JOGO_PREVISTO)
																<span class="label label-danger arrowed">
																@endif
																@if ($jogo->cd_status == \App\Models\StatusJogo::JOGO_FINALIZADO)
																<span class="label label-success arrowed-in arrowed-in-right">
																@endif
																{{$jogo->statusJogo->ds_status}}
																</span>
																</td>																
															</tr>
															@endforeach															
														</tbody>
													</table>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div><!-- /.col -->
								</div><!-- /.row -->

								

								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
@endsection

@section('pos_script')
		<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
		
		<script type="text/javascript">
			$(window).on('load', function() {
				@if ($id_mural_comum)
					//override dialog's title function to allow for HTML titles
					$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
						_title: function(title) {
							var $title = this.options.title || '&nbsp;'
							if( ("title_html" in this.options) && this.options.title_html == true )
								title.html($title);
							else title.text($title);
						}
					}));
					
					$( "#dialog-message" ).removeClass('hide').dialog({
						modal: true,
						title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='ace-icon fa fa-info-circle'></i> MENSAGEM</h4></div>",
						title_html: true,
						buttons: [
							{
								text: "OK",
								"class" : "btn btn-primary btn-minier",
								click: function() {
									$( this ).dialog( "close" ); 
								} 
							}
						]
					});
				@endif
				@if ($qt_votacoes > 0)
					//override dialog's title function to allow for HTML titles
					$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
						_title: function(title) {
							var $title = this.options.title || '&nbsp;'
							if( ("title_html" in this.options) && this.options.title_html == true )
								title.html($title);
							else title.text($title);
						}
					}));
					
					$( "#dialog-votacao" ).removeClass('hide').dialog({
						modal: true,
						title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='ace-icon fa fa-info-circle'></i> VOTAÇÃO </h4></div>",
						title_html: true,
						buttons: [
							{
								text: "Votar",
								"class" : "btn btn-primary btn-minier",
								click: function() {
									$('#formVotacao').submit(); 
								} 
							},
							{
								text: "Fechar",
								"class" : "btn btn-primary btn-minier",
								click: function() {
									$( this ).dialog( "close" ); 
								} 
							}
						]
					});
				@endif
			});
			jQuery(function($) {
				$('.easy-pie-chart.percentage').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
					var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
					var size = parseInt($(this).data('size')) || 50;
					$(this).easyPieChart({
						barColor: barColor,
						trackColor: trackColor,
						scaleColor: false,
						lineCap: 'butt',
						lineWidth: parseInt(size/10),
						animate: ace.vars['old_ie'] ? false : 1000,
						size: size
					});
				})
			
				$('.sparkline').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
					$(this).sparkline('html',
									 {
										tagValuesAttribute:'data-values',
										type: 'bar',
										barColor: barColor ,
										chartRangeMin:$(this).data('min') || 0
									 });
				});
			
			
			  //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
			  //but sometimes it brings up errors with normal resize event handlers
			  $.resize.throttleWindow = false;
			
			  //pie chart tooltip example
			  var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
			  var previousPoint = null;
			
			 
				/////////////////////////////////////
				$(document).one('ajaxloadstart.page', function(e) {
					$tooltip.remove();
				});
			
				$('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('.tab-content')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			
			
				$('.dialogs,.comments').ace_scroll({
					size: 300
			    });
				
				
				//Android's default browser somehow is confused when tapping on label which will lead to dragging the task
				//so disable dragging when clicking on label
				var agent = navigator.userAgent.toLowerCase();
				if(ace.vars['touch'] && ace.vars['android']) {
				  $('#tasks').on('touchstart', function(e){
					var li = $(e.target).closest('#tasks li');
					if(li.length == 0)return;
					var label = li.find('label.inline').get(0);
					if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
				  });
				}
			
				$('#tasks').sortable({
					opacity:0.8,
					revert:true,
					forceHelperSize:true,
					placeholder: 'draggable-placeholder',
					forcePlaceholderSize:true,
					tolerance:'pointer',
					stop: function( event, ui ) {
						//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
						$(ui.item).css('z-index', 'auto');
					}
					}
				);
				$('#tasks').disableSelection();
				$('#tasks input:checkbox').removeAttr('checked').on('click', function(){
					if(this.checked) $(this).closest('li').addClass('selected');
					else $(this).closest('li').removeClass('selected');
				});
			
			
				//show the dropdowns on top or bottom depending on window height and menu position
				$('#task-tab .dropdown-hover').on('mouseenter', function(e) {
					var offset = $(this).offset();
			
					var $w = $(window)
					if (offset.top > $w.scrollTop() + $w.innerHeight() - 100) 
						$(this).addClass('dropup');
					else $(this).removeClass('dropup');
				});
			
			})
		</script>
@endsection

@section('pos_script') @endsection