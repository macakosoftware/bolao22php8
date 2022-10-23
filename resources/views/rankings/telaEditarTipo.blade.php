@extends('template')

@section('titulo'){{ config('app.name') }} - Controle Ranking @endsection

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
								<i class="ace-icon fa fa-th-list"></i>
								Tipo de Ranking 
								&nbsp;
								<i class="ace-icon fa fa-edit"></i>
								Editar
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Tipo de Ranking
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Edição
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
								<form class="form-horizontal" role="form" id="formEditarTipo" name="formEditarTipo" method="POST" action="{{ route('tiposRankings.editarTipo') }}">
									{{ csrf_field() }}
									{{ Form::hidden('id_tipo', $tipo->id) }}
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ds_nome"> Nome </label>

										<div class="col-sm-9">
											<input type="text" name="ds_nome" id="ds_nome" placeholder="Nome do Ranking" class="col-xs-10 col-sm-12" value="{{$tipo->ds_nome}}"/>
										</div>										
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="dt_limite"> Data Limite </label>

										<div class="col-sm-9">
											<div class="input-group">										
    											<input class="form-control date-picker" id="dt_limite" name="dt_limite" type="text" data-date-format="dd/mm/yyyy" value="{{\Carbon\Carbon::parse($tipo->dt_limite)->format('d/m/Y')}}" />
    											<span class="input-group-addon">
    												<i class="fa fa-calendar bigger-110"></i>
    											</span>
    										</div>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hr_limite"> Horário Limite </label>

										<div class="col-sm-9">
											<div class="input-group">
												<input id="hr_limite" name="hr_limite" type="text" class="form-control input-mask-time" value="{{substr($tipo->hr_limite,0,5)}}" />
												<span class="input-group-addon">
													<i class="fa fa-clock-o bigger-110"></i>
												</span>
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="cd_status"> Status </label>

										<div class="col-sm-9">
										{!! Form::select('cd_status', $tb_status, $tipo->cd_status, $attributes = ['class'=>'col-xs-10 col-sm-5', 'tabindex'=> '-1']) !!}
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="id_ranking"> Tipo Ranking </label>

										<div class="col-sm-9">
										{!! Form::select('tp_fase', $tb_fases, $tipo->tp_fase, $attributes = ['class'=>'col-xs-10 col-sm-5', 'tabindex'=> '-1']) !!}
										</div>
									</div>
									
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-save bigger-110"></i>
												Salvar
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