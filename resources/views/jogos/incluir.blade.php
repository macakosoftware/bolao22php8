@extends('template')

@section('titulo'){{ config('app.name') }} - Incluir Jogo @endsection

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
								<i class="ace-icon fa fa-trophy"></i>
								Jogos 
								&nbsp;
								<i class="ace-icon fa fa-plus-square"></i>
								Incluir
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Jogos
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Incluir Novo Jogo
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
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" role="form" id="formIncluirJogo" name="formIncluirJogo" method="POST" action="{{ route('jogos.incluir') }}">
									{{ csrf_field() }}
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="id_selecao1"> Jogo </label>

										<div class="col-sm-4">
											{!! Form::select('id_selecao1', $tb_selecoes, 0, $attributes = ['class'=>'col-xs-10 col-sm-12 chosen-select', 'tabindex'=>'-1']) !!}
										</div>
										<div class="col-sm-1">
											<div class="text-center">										
											<li class="ace-icon fa fa-times"></li>
											</div>
										</div>
										<div class="col-sm-4">
											{!! Form::select('id_selecao2', $tb_selecoes, 0, $attributes = ['class'=>'col-xs-10 col-sm-12 chosen-select', 'tabindex'=>'-1']) !!}
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="id_descricao"> Colocar Descrição </label>
										
										<div class="col-sm-9">
											<label>
												<input name="id_descricao" id="id_descricao" class="ace ace-switch ace-switch-6" type="checkbox" />
												<span class="lbl"></span>
											</label>
										</div>
									</div>
									
									<div class="form-group desc_section">
										<label class="col-sm-3 control-label no-padding-right" for="id_selecao1"> Descrição </label>

										<div class="col-sm-4">
											<input type="text" name="desc1" id="desc1" placeholder="Descrição Seleção 1" class="col-xs-10 col-sm-12" />
										</div>
										<div class="col-sm-1">
											<div class="text-center">										
											<li class="ace-icon fa fa-times"></li>
											</div>
										</div>
										<div class="col-sm-4">
											<input type="text" name="desc2" id="desc2" placeholder="Descrição Seleção 2" class="col-xs-10 col-sm-12" />
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="dt_jogo"> Data </label>

										<div class="col-sm-3">
											<div class="input-group">										
    											<input class="form-control date-picker" id="dt_jogo" name="dt_jogo" type="text" data-date-format="dd/mm/yyyy" >
    											<span class="input-group-addon">
    												<i class="fa fa-calendar bigger-110"></i>
    											</span>
    										</div>
										</div>
										
										<div class="col-sm-6"></div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hr_jogo"> Horário </label>

										<div class="col-sm-3">
											<div class="input-group">
												<input id="hr_jogo" name="hr_jogo" type="text" class="form-control input-mask-time" />
												<span class="input-group-addon">
													<i class="fa fa-clock-o bigger-110"></i>
												</span>
											</div>
										</div>
										
										<div class="col-sm-6"></div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="id_estadio">Estádio</label>

										<div class="col-sm-9">
										{!! Form::select('id_estadio', $tb_estadios, 0, $attributes = ['class'=>'col-xs-10 col-sm-5', 'tabindex'=>'-1']) !!}
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="id_ranking">Tipo Jogo</label>

										<div class="col-sm-9">
										{!! Form::select('id_ranking', $tb_tipos_ranking, 0, $attributes = ['class'=>'col-xs-10 col-sm-5', 'tabindex'=>'-1']) !!}
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="id_penal"> Habilitar Penalties? </label>
										
										<div class="col-sm-9">
											<label>
												<input name="id_penal" id="id_penal" class="ace ace-switch ace-switch-6" type="checkbox" />
												<span class="lbl"></span>
											</label>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="id_notificacao"> Enviar Notificação? </label>
										
										<div class="col-sm-9">
											<label>
												<input name="id_notificacao" id="id_notificacao" class="ace ace-switch ace-switch-6" type="checkbox" />
												<span class="lbl"></span>
											</label>
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
	<script>
    	$(document).ready(function() {
    		if ($('#id_descricao').is(':checked')){
    			$('.desc_section').show();
    			$('#desc1').prop('required',true);
            	$('#desc2').prop('required',true);
    		}
    		else{				
    			$('.desc_section').hide();
    		}
    		$('#id_descricao').change(function() {
        	if($(this).is(":checked")) {
            	$('.desc_section').show();
            	$('#desc1').prop('required',true);
            	$('#desc2').prop('required',true);
        	}
        	else {
        		$('.desc_section').hide();
        		$('#desc1').prop('required',false);
            	$('#desc2').prop('required',false);
        	}
    		});
    	});
		jQuery(function($) {
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