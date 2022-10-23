@extends('template')

@section('titulo'){{ config('app.name') }} - Incluir Usuário @endsection

@section('header_css')
<link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-timepicker.min.css') }}" />
@endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-table"></i>
								Tipos de Rankings 
								&nbsp;
								<i class="ace-icon fa fa-plus-square"></i>
								Incluir
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Tipos de Rankings
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Incluir novo Tipo
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
							
						
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" role="form" id="formIncluirTipoRanking" name="formIncluirTipoRanking" method="POST" action="{{ route('tiposRankings.incluir') }}">
									{{ csrf_field() }}
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ds_nome"> Nome </label>

										<div class="col-sm-9">
											<input type="text" name="ds_nome" id="ds_nome" placeholder="Nome" class="col-xs-10 col-sm-5" required/>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="nome"> Nome Abreviado </label>

										<div class="col-sm-9">
											<input type="text" name="ds_abreviado" id="ds_abreviado" placeholder="Nome Abreviado" class="col-xs-10 col-sm-5" required/>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="dt_limite"> Data Limite </label>

										<div class="col-sm-3">
											<div class="input-group">										
    											<input class="form-control date-picker" id="dt_limite" name="dt_limite" type="text" data-date-format="dd/mm/yyyy" >
    											<span class="input-group-addon">
    												<i class="fa fa-calendar bigger-110"></i>
    											</span>
    										</div>
										</div>
										
										<div class="col-sm-6"></div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hr_limite"> Horário Limite </label>

										<div class="col-sm-3">
											<div class="input-group">
												<input id="hr_limite" name="hr_limite" type="text" class="form-control input-mask-time" />
												<span class="input-group-addon">
													<i class="fa fa-clock-o bigger-110"></i>
												</span>
											</div>
										</div>
										
										<div class="col-sm-6"></div>
									</div>

									<div class="space-4"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="id_handicap_casa"> Handicap Casa </label>
										
										<div class="col-sm-9">
											<label>
												<input name="id_handicap_casa" id="id_handicap_casa" class="ace ace-switch ace-switch-6" type="checkbox" />
												<span class="lbl"></span>
											</label>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="cd_perfil"> Tipo Fase </label>

										<div class="col-sm-9">
										{!! Form::select('tp_fase', $tb_fases, 0, $attributes = ['class'=>'col-xs-10 col-sm-5', 'tabindex'=>'-1', 'id'=>'tp_fase']) !!}
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="cd_perfil"> Série </label>

										<div class="col-sm-9">
										{!! Form::select('tp_serie', $tb_series, 0, $attributes = ['class'=>'col-xs-10 col-sm-5', 'tabindex'=>'-1', 'id'=>'tp_serie']) !!}
										</div>
									</div>
									
									<div class="form-group ranking_section">
										<label class="col-sm-3 control-label no-padding-top" for="duallist"> Rankings Simples </label>

										<div class="col-sm-8">
											<select multiple="multiple" size="10" name="cd_ranking[]" id="cd_ranking">
												@if (count($rankings) > 0)
												@foreach($rankings as $ranking)
												<option value="{{$ranking->id}}">{{$ranking->ds_nome}}</option>
												@endforeach
												@endif
											</select>

											<div class="hr hr-16 hr-dotted"></div>
										</div>
									</div>

									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Incluir
											</button>

											&nbsp; &nbsp; &nbsp;
											<button class="btn" type="reset">
												<i class="ace-icon fa fa-undo bigger-110"></i>
												Reset
											</button>
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
	<script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap-timepicker.min.js') }}"></script>	
	<script src="{{ asset('assets/js/moment.min.js') }}"></script>	
	<script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.bootstrap-duallistbox.min.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap-multiselect.min.js') }}"></script>
	<script>
    	$(document).ready(function() {
    		if ($('#tp_fase').val() == '{{\App\Models\TipoRanking::TIPO_FASE_COMPOSTO}}'){
    			$('.ranking_section').show(); 
    		}
    		else {
    			$('.ranking_section').hide();
    		}	    		
    		$('#tp_fase').change(function() {        		
    			if($(this).val() == '{{\App\Models\TipoRanking::TIPO_FASE_COMPOSTO}}'){        		
    	    		$('.ranking_section').show();
        		}
        		else {
    	    		$('.ranking_section').hide();
        		}
    		});
    	});    	
		jQuery(function($) {
			var demo1 = $('select[name="cd_ranking[]"]').bootstrapDualListbox({infoTextFiltered: '<span class="label label-purple label-lg">Com Filtro</span>'});
			var container1 = demo1.bootstrapDualListbox('getContainer');
			container1.find('.btn').addClass('btn-white btn-info btn-bold');
				
			//////////////////
			$('.multiselect').multiselect({
				 enableFiltering: true,
				 enableHTML: true,
				 buttonClass: 'btn btn-white btn-primary',
				 templates: {
					button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown"><span class="multiselect-selected-text"></span> &nbsp;<b class="fa fa-caret-down"></b></button>',
					ul: '<ul class="multiselect-container dropdown-menu"></ul>',
					filter: '<li class="multiselect-item filter"><div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span><input class="form-control multiselect-search" type="text"></div></li>',
					filterClearBtn: '<span class="input-group-btn"><button class="btn btn-default btn-white btn-grey multiselect-clear-filter" type="button"><i class="fa fa-times-circle red2"></i></button></span>',
					li: '<li><a tabindex="0"><label></label></a></li>',
			        divider: '<li class="multiselect-item divider"></li>',
			        liGroup: '<li class="multiselect-item multiselect-group"><label></label></li>'
				 }
			});
			
			$('.date-picker').datepicker({
				autoclose: true,
				todayHighlight: true,
				dateFormat: 'dd/mm/yy'
			})
			//show datepicker when clicking on the icon
			.next().on(ace.click_event, function(){
				$(this).prev().focus();
			});
		
			//or change it into a date range picker
			$('.input-daterange').datepicker({autoclose:true});
		
		
			//to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
			$('input[name=date-range-picker]').daterangepicker({
				'applyClass' : 'btn-sm btn-success',
				'cancelClass' : 'btn-sm btn-default',
				locale: {
					applyLabel: 'Apply',
					cancelLabel: 'Cancel',
				}
			})

			$('.input-mask-time').mask('99:99');
			
			if(!ace.vars['touch']) {
				$('.chosen-select').chosen({allow_single_deselect:true}); 
				//resize the chosen on window resize
				
				//resize chosen on sidebar collapse/expand
				$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
					if(event_name != 'sidebar_collapsed') return;
					$('.chosen-select').each(function() {
						 var $this = $(this);
						 $this.next().css({'width': $this.parent().width()});
					})
				});
		
			}
		});
	</script>
@endsection