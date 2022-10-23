@extends('template')

@section('titulo'){{ config('app.name') }} - Propostas Recebidas - Ofertas @endsection

@section('header_css') @endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="menu-icon fa fa-id-card-o"></i>
								Figurinhas 
								&nbsp;
								<i class="menu-icon fa fa-shopping-cart"></i>
								Propostas
								&nbsp;
								<i class="menu-icon fa fa-inbox"></i>
								Propostas Recebidas
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Figurinhas
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Propostas
									<i class="ace-icon fa fa-angle-double-right"></i>
									Propostas Recebidas - Lista de Ofertas
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
								<div class="col-sm-3"></div>
								<div align="col-sm-9">
									<img alt="{{$transacao->jogador->ds_nome}}" src="{{url('figurinhas/mostrar')}}?id_jogador={{$transacao->jogador->id}}" />
								</div>
							</div>
						</div>
							
						<hr/>
						<div class="row">
							<div class="col-xs-12">										
	
							<form class="form-horizontal" role="form" id="formPropostas" name="formPropostas" method="GET" action="{{ route('figurinhas.visualizarProposta') }}">
									{{ csrf_field() }}
	
										<div class="clearfix">
											<div class="pull-right tableTools-container"></div>
										</div>
										<div class="table-header">
											Ofertas
										</div>

										<!-- div.table-responsive -->

										<!-- div.dataTables_borderWrap -->
										<div>
											<table id="dynamic-table" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>	
														<th>&nbsp;</th>
														<th>Usuário Oferta</th>
														<th>Figurinha(s)</th>														
														<th>Valor Venda</th>														
														<th>Data/Hora</th>														
													</tr>
												</thead>

												<tbody>
													@foreach($ofertas as $oferta)
													<tr>
														<td>
															<input type="radio" name="id_proposta" id="id_proposta_{{$oferta->id}}" value="{{$oferta->id}}" />
														</td>														
														<td>
															@if (\App\Funcoes\VerificaAvatar::verificar($oferta->id_user_proposta))
                                							<img width="30px" height="30px" src="data:image/png;base64,{{ base64_encode(Storage::get('avatars/'.$oferta->id_user_proposta))}}" alt="Photo" />
                                							@else
                                							<img width="30px" height="30px" src="{{ asset('assets/images/avatars/user.jpg') }}" alt="Photo" />                                								
                                							@endif	
															{{$oferta->usuarioProposta->name}}
														</td>
														<td>
															@if (count($oferta->jogadoresTroca) > 0)
																<ul>
																@foreach($oferta->jogadoresTroca as $troca)
																	<li>
																	<img src="{{ asset('images/brasoes') }}/{{$troca->jogador->selecao->ds_icone}}" />
																	{{$troca->jogador->ds_nome}} / 
																	{{$troca->jogador->posicao->ds_nome}}
																	@if (\App\Funcoes\VerificaFigurinhaColecao::verificar(Auth::user(),$troca->jogador))
                													<span class="label label-success arrowed-in arrowed-in-right">
                													Você Já Tem
                													</span>
                													@else
                													<span class="label label-danger arrowed">
                													Não Tem
                    												</span>
                													@endif	
																	</li>
																@endforeach
																</ul>
															@else
															-
															@endif
														</td>
														<td>
															@if ($oferta->vl_proposta > 0)
															{{number_format($oferta->vl_proposta, 2, ',','')}}
															@else
															&nbsp;
															@endif
														</td>
														<td>
															{{$oferta->updated_at}}															
														</td>
													</tr>
													@endforeach
												</tbody>
											</table>
											<div class="clearfix form-actions">
												<div class="col-md-offset-3 col-md-9">
													<button class="btn btn-success" type="submit" name="submit" value="{{\App\Funcoes\AtualizaProposta::ACAO_ACEITAR}}">
													<i class="ace-icon fa fa-check bigger-110"></i>
													Aceitar
													</button>
													&nbsp;&nbsp;
													<button class="btn btn-danger" type="submit" name="submit" value="{{\App\Funcoes\AtualizaProposta::ACAO_REJEITAR}}">
													<i class="ace-icon fa fa-times bigger-110"></i>
													Rejeitar
													</button>
													&nbsp;&nbsp;
													<button class="btn btn-info" type="submit" name="submit" value="detalhar">
													<i class="ace-icon fa fa-search bigger-110"></i>
													Ver Detalhes
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
					"pageLength": 10,	
					bAutoWidth: false,
					"aoColumns": [				
						{ "bSortable": false },	  
						null, null, null, null
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
