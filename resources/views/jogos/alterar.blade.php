@extends('template')

@section('titulo'){{ config('app.name') }} - Alterar Jogo @endsection

@section('header_css')
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
								<i class="ace-icon fa fa-edit"></i>
								Alterar
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Jogos
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Alterar Jogo
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
								<form class="form-horizontal" role="form" id="formAlterarJogo" name="formAlterarJogo" method="POST" action="{{ route('jogos.alterar') }}">
									{{ csrf_field() }}
									{{ Form::hidden('id_jogo', $jogo->id) }}
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="id_selecao1"> Jogo </label>

										<div class="col-sm-4">
											{!! Form::select('id_selecao1', $tb_selecoes, $jogo->id_selecao1, $attributes = ['class'=>'col-xs-10 col-sm-12', 'tabindex'=>'-1']) !!}
										</div>
										<div class="col-sm-1">
											<div class="text-center">										
											<li class="ace-icon fa fa-times"></li>
											</div>
										</div>
										<div class="col-sm-4">
											{!! Form::select('id_selecao2', $tb_selecoes, $jogo->id_selecao2, $attributes = ['class'=>'col-xs-10 col-sm-12', 'tabindex'=>'-1']) !!}
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
											<input type="text" name="desc1" id="desc1" placeholder="Descrição Seleção 1" class="col-xs-10 col-sm-12" value="{{ $jogo->ds_selecao1 }}"/>
										</div>
										<div class="col-sm-1">
											<div class="text-center">										
											<li class="ace-icon fa fa-times"></li>
											</div>
										</div>
										<div class="col-sm-4">
											<input type="text" name="desc2" id="desc2" placeholder="Descrição Seleção 2" class="col-xs-10 col-sm-12" value="{{ $jogo->ds_selecao2 }}"/>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="dt_jogo"> Data </label>

										<div class="col-sm-9">
											<div class="input-group">										
    											<input class="form-control date-picker" id="dt_jogo" name="dt_jogo" type="text" data-date-format="dd/mm/yyyy" value="{{ \Carbon\Carbon::parse($jogo->dt_jogo)->format('d/m/Y') }}">
    											<span class="input-group-addon">
    												<i class="fa fa-calendar bigger-110"></i>
    											</span>
    										</div>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hr_jogo"> Horário </label>

										<div class="col-sm-9">
											<div class="input-group">
												<input id="hr_jogo" name="hr_jogo" type="text" class="form-control input-mask-time" value="{{ $jogo->hr_jogo }}"/>
												<span class="input-group-addon">
													<i class="fa fa-clock-o bigger-110"></i>
												</span>
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="id_estadio">Estádio</label>

										<div class="col-sm-9">
										{!! Form::select('id_estadio', $tb_estadios, $jogo->id_estadio, $attributes = ['class'=>'col-xs-10 col-sm-5', 'tabindex'=>'-1']) !!}
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="id_ranking">Tipo Jogo</label>

										<div class="col-sm-9">
										{!! Form::select('id_ranking', $tb_tipos_ranking, $jogo->cd_ranking, $attributes = ['class'=>'col-xs-10 col-sm-5', 'tabindex'=>'-1']) !!}
										</div>
									</div>
									
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Alterar
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
	<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap-timepicker.min.js') }}"></script>	
	<script src="{{ asset('assets/js/moment.min.js') }}"></script>	
	<script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.maskedinput.min.js') }}"></script>	
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
					
		});
	</script>
@endsection