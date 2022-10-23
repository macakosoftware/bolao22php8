@extends('template') @section('titulo'){{ config('app.name') }} - Consultar Palpites @endsection 
@section('header_css')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}" />
@endsection

@section('content')
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li><i class="menu-icon fa fa-line-chart"></i> Ranking &nbsp; <i
					class="menu-icon fa fa-search"></i> Consultar</li>

			</ul>
			<!-- /.breadcrumb -->

		</div>

		<div class="page-content">

			<div class="page-header">
				<h1>
					Ranking <small> <i class="ace-icon fa fa-angle-double-right"></i>
						Consulta Ranking {{$tipoRanking->ds_nome}}
					</small>
				</h1>
			</div>
			<!-- /.page-header -->

			<div class="row">

				@if ($errors->any())
				<div class="alert alert-danger">
					<button class="close" data-dismiss="alert">
						<i class="ace-icon fa fa-times"></i>
					</button>
					<ul>
						@foreach ($errors->all() as $error)
						<li><i class="ace-icon fa fa-exclamation-circle"></i> {{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif @if (session('mensagem'))
				<div class="alert alert-info">
					<button class="close" data-dismiss="alert">
						<i class="ace-icon fa fa-times"></i>
					</button>
					<ul>
						<li><i class="ace-icon fa fa-info"></i> {{ session('mensagem') }}</li>
					</ul>
				</div>
				@endif @if (session('sucesso'))
				<div class="alert alert-success">
					<button class="close" data-dismiss="alert">
						<i class="ace-icon fa fa-times"></i>
					</button>
					<ul>
						<li><i class="ace-icon fa fa-check-square"></i> {{
							session('sucesso') }}</li>
					</ul>
				</div>
				@endif

				<div class="col-xs-12">
					<form class="form-horizontal" role="form" id="formApostas"
						name="formApostas" method="POST"
						action="{{ route('apostas.editar') }}">
						{{ csrf_field() }}

						<div class="clearfix">
							<div class="pull-right tableTools-container"></div>
						</div>
						<div class="table-header">Participantes X Palpites</div>

						<!-- div.table-responsive -->

						<!-- div.dataTables_borderWrap -->
						<div>
							<table id="dynamic-table"
								class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>Nome</th>
										<th>Apostas</th>
										<th>Pontos</th>
										<th>Qt.Resultados</th>
										<th>Qt.Pl.Cheio</th>
										<th>Qt.Pl.Parcial</th>
										<th>Maior Pontuação</th>	
										<th></th>																													
									</tr>
								</thead>

								<tbody>
									@foreach($tb_ranking as $ranking)
									<tr>
										<td>{{$ranking['nr_posicao']}}</td>
										<td>
										@if ($ranking['id_avatar'])
        								<img width="50px" height="50px" src="{{ $ranking['img_avatar'] }}" alt="Photo" />
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
										<td>{{$ranking['qt_acertos_resultado']}}</td>
										<td>{{$ranking['qt_acertos_cheio']}}</td>
										<td>{{$ranking['qt_acertos_parcial']}}</td>
										<td>{{$ranking['qt_pontos_maior']}}</td>
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
							
						</div>
					</form>
				</div>

			</div>
			<!-- /.row -->
		</div>
		<!-- /.page-content -->
	</div>
</div>
<!-- /.main-content -->
@endsection @section('pos_script')
<!-- page specific plugin scripts -->
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script
	src="{{ asset('assets/js/jquery.dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.select.min.js') }}"></script>
	
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.ui.touch-punch.min.js') }}"></script>


<script type="text/javascript">
			jQuery(function($) {
				//initiate dataTables plugin
				var myTable = 
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable( {
					bAutoWidth: false,
					"aoColumns": [					  
						null, null,null, null, null, null, null, null,
						 { "bSortable": false }
					],
					"aaSorting": [],
					
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
				
			})
		</script>
@endsection
