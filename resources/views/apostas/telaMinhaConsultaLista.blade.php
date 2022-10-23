@extends('template') @section('titulo'){{ config('app.name') }} - Consultar Palpites @endsection 
@section('header_css')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" />
@endsection

@section('content')
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li><i class="menu-icon fa fa-money"></i> Palpites &nbsp; <i
					class="menu-icon fa fa-edit"></i> Consultar</li>

			</ul>
			<!-- /.breadcrumb -->

		</div>

		<div class="page-content">

			<div class="page-header">
				<h1>
					Palpites <small> <i class="ace-icon fa fa-angle-double-right"></i>
						Consultar os meus Palpites
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
				<!-- PAGE CONTENT BEGINS -->
				<form class="form-horizontal" role="form" id="formConsultaPalpites" name="formConsultaPalpites" method="GET" action="{{ route('apostas.telaMinhaConsultaLista') }}">
					{{ csrf_field() }}
					
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right"  for="cd_perfil">Fase/Rodada</label>

						<div class="col-sm-9">
						{!! Form::select('cd_ranking', $tb_rankings, 0, $attributes = ['class'=>'col-xs-10 col-sm-5', 'tabindex'=>'-1']) !!}
						</div>
					</div>
					
					<div class="space-4"></div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right"  for="cd_perfil">Situação Jogo</label>

						<div class="col-sm-9">
						{!! Form::select('cd_status', $tb_status, 0, $attributes = ['class'=>'col-xs-10 col-sm-5', 'tabindex'=>'-1']) !!}
						</div>
					</div>

					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-9">
							<button class="btn btn-info" type="submit">
								<i class="ace-icon fa fa-check bigger-110"></i>
								Filtrar
							</button>
						</div>
					</div>
					</form>
				</div>
			</div><!-- /.row -->	

			<div class="row">

				<div class="col-xs-12">
					<form class="form-horizontal" role="form" id="formApostas"
						name="formApostas" method="POST"
						action="{{ route('apostas.editar') }}">
						{{ csrf_field() }}

						<div class="clearfix">
							<div class="pull-right tableTools-container"></div>
						</div>
						<div class="table-header">Palpites</div>

						<!-- div.table-responsive -->

						<!-- div.dataTables_borderWrap -->
						<div>
							<table id="dynamic-table"
								class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>Data/Hora</th>
										<th>Fase</th>										
										<th>Seleção 1</th>
										<th>Placar 1</th>
										<th>X</th>
										<th>Placar 2</th>
										<th>Seleção 2</th>
										<th>Penal</th>
										<th>Estádio</th>
										<th>Pontos Máximo</th>										
										<th>Pontos Resultado</th>										
										<th>Placar Cheio</th>										
										<th>Placar Parcial</th>										
										<th>Bônus</th>										
									</tr>
								</thead>

								<tbody>
									@foreach($tb_jogos as $jogo)
									<tr>
										<td>{{
											\Carbon\Carbon::parse($jogo['dt_jogo'])->format('d/m/Y')}} -
											{{substr($jogo['hr_jogo'], 0, 5)}}
											@if ($jogo['cd_status'] == \App\Models\StatusJogo::JOGO_FINALIZADO)
											<i class="ace-icon fa fa-flag bigger-130 green"></i>
											@else
											<i class="ace-icon fa fa-question-circle bigger-130 red"></i>
											@endif
											</td>
										<td>{{ $jogo['ds_ranking'] }}</td>										
										<td><img src="{{ asset('images/brasoes') }}/{{$jogo['ds_icone1']}}" />
											<span class="{{$jogo['class_selecao1']}}">											
											{{ $jogo['ds_nome_selecao1'] }}											
											</span>												
										</td>
										<td class="center">
										<span class="{{$jogo['class_placar1']}}">
										{{$jogo['qt_aposta_selecao1']}}
										@if ($jogo['id_mostra1'])
										&nbsp;
										<label class="btn btn-xs btn-yellow">{{$jogo['qt_jogo_selecao1']}}</label>
										@endif
										</span>
										</td>
										<td class="center">
										<span class="{{$jogo['class_X']}}">
										X
										</span>
										</td>
										<td class="center">
										<span class="{{$jogo['class_placar2']}}">
										{{$jogo['qt_aposta_selecao2']}}
										@if ($jogo['id_mostra2'])
										&nbsp;
										<label class="btn btn-xs btn-yellow">{{$jogo['qt_jogo_selecao2']}}</label>
										@endif
										</span>
										</td>
										<td>
										<img src="{{ asset('images/brasoes') }}/{{$jogo['ds_icone2']}}" />
										<span class="{{$jogo['class_selecao2']}}">
										{{ $jogo['ds_nome_selecao2'] }}
										</span>										
										</td>
										<td>
										@if ($jogo['id_penal'] && $jogo['id_selecao_penal'] > 0)  
										<img src="{{ asset('images/brasoes') }}/{{$jogo['ds_icone_penal']}}" /><span class="{{$jogo['class_penal']}}">{{$jogo['ds_selecao_penal']}}</span>
										@if ($jogo['id_mostra_penal'])
										&nbsp;
										<label class="btn btn-xs btn-yellow">{{$jogo['ds_jogo_selecao_penal']}}</label>
										@endif 
										@endif
										</td>
										<td>{{ $jogo['ds_estadio'] }}</td>										
										<td>
										{{ $jogo['qt_pontos_maximo'] }}
										</td>
										<td>
										{{ $jogo['qt_pontos_resultado'] }}
										</td>
										<td>
										{{ $jogo['qt_pontos_placar_cheio'] }}
										</td>
										<td>
										{{ $jogo['qt_pontos_placar_parcial'] }}
										</td>
										<td>
										{{ $jogo['qt_pontos_bonus'] }}
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
<script src="{{ asset('assets/js/jquery.dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>	
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
						null, null, null, null,
						{ "bSortable": false },
						null, null, null, null, null, null, null, null, null
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
