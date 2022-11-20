@extends('template')

@section('titulo'){{ config('app.name') }} - Manutenção de Jogos @endsection

@section('header_css') @endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="menu-icon fa fa-users"></i>
								Jogos 
								&nbsp;
								<i class="menu-icon fa fa-edit"></i>
								Recibo Palpites
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Jogos
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Seleção de Jogo para Gerar Recibo
								</small>
							</h1>
						</div><!-- /.page-header -->
						
						<div class="row">

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
							
							<div class="col-xs-12">										
		
								<form class="form-horizontal" role="form" id="formManutencaoJogos"
								name="formManutencaoJogos" method="POST"
								action="{{ route('jogos.recalcular') }}">
								{{ csrf_field() }}			
	
										<div class="clearfix">
											<div class="pull-right tableTools-container"></div>
										</div>
										<div class="table-header">
											Jogos
										</div>

										<!-- div.table-responsive -->

										<!-- div.dataTables_borderWrap -->
										<div>
											<table id="dynamic-table" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>														
														<th>Situação</th>
														<th>Data/Hora</th>
														<th>Fase</th>														
														<th>Seleção 1</th>
														<th>Placar 1</th>
														<th>X</th>
														<th>Placar 2</th>
														<th>Seleção 2</th>
														<th>Estádio</th>
														<th></th>
													</tr>
												</thead>

												<tbody>
													@foreach($jogos as $jogo)
													<tr>
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
														{{ $jogo->statusJogo->ds_status }}
														</span>
														</td>
														<td>{{ \Carbon\Carbon::parse($jogo->dt_jogo)->format('d/m/Y')}} - {{$jogo->hr_jogo}}</td>
														<td>{{ $jogo->tipoRanking->ds_nome }}</td>
														<td>
														<img src="{{ asset('images/brasoes') }}/{{$jogo->selecao1->ds_icone}}" width="10%" height="10%"/>
														{{ $jogo->selecao1->ds_nome }}
														@if ($jogo->nr_pontos_handcap1 > $jogo->nr_pontos_handcap2)
														<span class="label label-sm label-inverse">
														@else
														<span class="label label-sm label-success">
														@endif
														{{$jogo->nr_pontos_handcap1}}
														</span>
														</td>
														<td>@if ($jogo->cd_status != \App\Models\StatusJogo::JOGO_PROGRAMADO) {{ $jogo->qt_gols_selecao1 }} @endif</td>
														<td>X														
														<span class="label label-sm label-inverse">														
														{{$jogo->nr_pontos_handcapX}}
														</span>
														</td>
														<td>@if ($jogo->cd_status != \App\Models\StatusJogo::JOGO_PROGRAMADO) {{ $jogo->qt_gols_selecao2 }} @endif</td>
														<td>
														<img src="{{ asset('images/brasoes') }}/{{$jogo->selecao2->ds_icone}}" width="10%" height="10%" />
														{{ $jogo->selecao2->ds_nome }}
														@if ($jogo->nr_pontos_handcap2 > $jogo->nr_pontos_handcap1)
														<span class="label label-sm label-inverse">
														@else
														<span class="label label-sm label-success">
														@endif
														{{$jogo->nr_pontos_handcap2}}
														</span>
														</td>
														<td>{{ $jogo->estadio->ds_nome }}</td>														
														<td>
															<div class="hidden-sm hidden-xs action-buttons">
																<a class="blue" href="{{ url('jogos/telaDetalhe') }}?id={{$jogo->id}}">
																	<i class="ace-icon fa fa-search-plus bigger-130"></i>
																</a>

																<a class="green" href="{{ url('jogos/telaAlterar') }}?id={{$jogo->id}}">
																	<i class="ace-icon fa fa-pencil bigger-130"></i>
																</a>

																<a class="red" href="{{ url('jogos/telaExcluir') }}?id={{$jogo->id}}">
																	<i class="ace-icon fa fa-trash-o bigger-130"></i>
																</a>
															</div>

															<div class="hidden-md hidden-lg">
																<div class="inline pos-rel">
																	<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
																		<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
																	</button>

																	<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
																		<li>
																			<a href="{{ url('jogos/telaDetalhe') }}?id={{$jogo->id}}" class="tooltip-info" data-rel="tooltip" title="View">
																				<span class="blue">
																					<i class="ace-icon fa fa-search-plus bigger-120"></i>
																				</span>
																			</a>
																		</li>

																		<li>
																			<a href="{{ url('jogos/telaAlterar') }}?id={{$jogo->id}}" class="tooltip-success" data-rel="tooltip" title="Edit">
																				<span class="green">
																					<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																				</span>
																			</a>
																		</li>

																		<li>
																			<a href="{{ url('jogos/telaExcluir') }}?id={{$jogo->id}}" class="tooltip-error" data-rel="tooltip" title="Delete">
																				<span class="red">
																					<i class="ace-icon fa fa-trash-o bigger-120"></i>
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
											<div class="clearfix form-actions">
												<div class="col-md-offset-3 col-md-9">
													<button class="btn btn-info" type="submit">
													<i class="ace-icon fa fa-check bigger-110"></i>
													Recalcular Handcap
													</button>
												</div>
											</div>
										</div>
										</form>
									</div>
							
							</div><!-- /.row -->						
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
@endsection

@section('pos_script')
	<!-- page specific plugin scripts -->
	<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('assets/js/dataTables.buttons.min.js') }}"></script>
	<script src="{{ asset('assets/js/buttons.flash.min.js') }}"></script>
	<script src="{{ asset('assets/js/buttons.html5.min.js') }}"></script>
	<script src="{{ asset('assets/js/buttons.print.min.js') }}"></script>
	<script src="{{ asset('assets/js/buttons.colVis.min.js') }}"></script>
	<script src="{{ asset('assets/js/dataTables.select.min.js') }}"></script>
	

	<script type="text/javascript">
			jQuery(function($) {
				//initiate dataTables plugin
				var myTable = 
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable( {
					bAutoWidth: false,
					"aoColumns": [					  
						null, null,null, null, null,
						{ "bSortable": false },
						null, null, null,
						{ "bSortable": false }
					],
					"aaSorting": [],
					
					
					//"bProcessing": true,
			        //"bServerSide": true,
			        //"sAjaxSource": "http://127.0.0.1/table.php"	,
			
					//,
					//"sScrollY": "200px",
					//"bPaginate": false,
			
					//"sScrollX": "100%",
					//"sScrollXInner": "120%",
					//"bScrollCollapse": true,
					//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
					//you may want to wrap the table inside a "div.dataTables_borderWrap" element
			
					//"iDisplayLength": 50
			
			
					select: {
						style: 'multi'
					}
			    } );
			
				
				
				$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
				
				new $.fn.dataTable.Buttons( myTable, {
					buttons: [
					  {
						"extend": "colvis",
						"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
						"className": "btn btn-white btn-primary btn-bold",
						columns: ':not(:first):not(:last)'
					  },
					  {
						"extend": "copy",
						"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "csv",
						"text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },					 
					  {
						"extend": "print",
						"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
						"className": "btn btn-white btn-primary btn-bold",
						autoPrint: false,
						message: 'This print was produced using the Print button for DataTables'
					  }		  
					]
				} );
				myTable.buttons().container().appendTo( $('.tableTools-container') );
				
				//style the message box
				var defaultCopyAction = myTable.button(1).action();
				myTable.button(1).action(function (e, dt, button, config) {
					defaultCopyAction(e, dt, button, config);
					$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
				});
				
				
				var defaultColvisAction = myTable.button(0).action();
				myTable.button(0).action(function (e, dt, button, config) {
					
					defaultColvisAction(e, dt, button, config);
					
					
					if($('.dt-button-collection > .dropdown-menu').length == 0) {
						$('.dt-button-collection')
						.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
						.find('a').attr('href', '#').wrap("<li />")
					}
					$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
				});
			
				////
			
				setTimeout(function() {
					$($('.tableTools-container')).find('a.dt-button').each(function() {
						var div = $(this).find(' > div').first();
						if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
						else $(this).tooltip({container: 'body', title: $(this).text()});
					});
				}, 500);
				
				
				
				
				
				myTable.on( 'select', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
					}
				} );
				myTable.on( 'deselect', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
					}
				} );
			
			
			
			
				/////////////////////////////////
				//table checkboxes
				$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
				
				//select/deselect all rows according to table header checkbox
				$('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$('#dynamic-table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) myTable.row(row).select();
						else  myTable.row(row).deselect();
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
					var row = $(this).closest('tr').get(0);
					if(this.checked) myTable.row(row).deselect();
					else myTable.row(row).select();
				});
			
			
			
				$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
					e.stopImmediatePropagation();
					e.stopPropagation();
					e.preventDefault();
				});
				
				
				
				//And for the first simple table, which doesn't have TableTools or dataTables
				//select/deselect all rows according to table header checkbox
				var active_class = 'active';
				$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$(this).closest('table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
						else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#simple-table').on('click', 'td input[type=checkbox]' , function(){
					var $row = $(this).closest('tr');
					if($row.is('.detail-row ')) return;
					if(this.checked) $row.addClass(active_class);
					else $row.removeClass(active_class);
				});
			
				
			
				/********************************/
				//add tooltip for small view action buttons in dropdown menu
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				
				//tooltip placement on right or left
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
				
				
				
				
				/***************/
				$('.show-details-btn').on('click', function(e) {
					e.preventDefault();
					$(this).closest('tr').next().toggleClass('open');
					$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
				});
				/***************/
				
				
				
				
				
				/**
				//add horizontal scrollbars to a simple table
				$('#simple-table').css({'width':'2000px', 'max-width': 'none'}).wrap('<div style="width: 1000px;" />').parent().ace_scroll(
				  {
					horizontal: true,
					styleClass: 'scroll-top scroll-dark scroll-visible',//show the scrollbars on top(default is bottom)
					size: 2000,
					mouseWheelLock: true
				  }
				).css('padding-top', '12px');
				*/
			
			
			})
		</script>
@endsection