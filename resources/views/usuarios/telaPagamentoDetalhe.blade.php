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
								<i class="ace-icon fa fa-users"></i>
								Usuários 
								&nbsp;
								<i class="ace-icon fa fa-money"></i>
								Pagamento
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Usuários
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Informar Pagamento
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
								<form class="form-horizontal" role="form" id="formPagamento" name="formPagamento" method="POST" action="{{ route('usuario.incluirPagamento') }}">
									{{ csrf_field() }}									
									{{ Form::hidden('id_user_selecao', $usuario_selecao->id) }}
									<div class="form-group">
										<div class="col-sm-3">										
										<div align="right">Nome </div> 										
										</div>

										<div class="col-sm-9">										
										<b>{{$usuario_selecao->name }}</b>										
										</div>
									</div>
									
									<div class="form-group">
										<div class="col-sm-3">										
										<div align="right">Valor Pago</div>										
										</div>

										<div class="col-sm-9">
										<b>R${{number_format($usuario_selecao->vl_pagamento,2,',','') }}</b>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="dt_pagamento"> Data </label>

										<div class="col-sm-3">
											<div class="input-group col">										
    											<input class="form-control date-picker" id="dt_pagamento" name="dt_pagamento" type="text" data-date-format="dd/mm/yyyy">
    											<span class="input-group-addon">
    												<i class="fa fa-calendar bigger-110"></i>
    											</span>
    										</div>
										</div>
										
										<div class="col-sm-6"></div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hr_pagamento"> Hora Pagamento </label>

										<div class="col-sm-3">
											<div class="input-group">
												<input id="hr_pagamento" name="hr_pagamento" type="text" class="form-control input-mask-time" />
												<span class="input-group-addon">
													<i class="fa fa-clock-o bigger-110"></i>
												</span>
											</div>
										</div>
										
										<div class="col-sm-6"></div>
									</div>
									
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="cd_perfil">Forma de Pagamento</label>

										<div class="col-sm-9">
										{!! Form::select('cd_forma', $tb_formas, 0, $attributes = ['class'=>'col-xs-10 col-sm-5', 'tabindex'=>'-1']) !!}
										</div>
									</div>
									
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="vl_pagamento">Valor Pagamento</label>

										<div class="col-sm-9">
											<div class="clearfix">
												<input type="text" name="vl_pagamento" id="vl_pagamento"/>
											</div>
										</div>
									</div>
									
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="vl_pagamento">Observação</label>

										<div class="col-sm-9">
											<div class="clearfix">
												<input type="text" name="ds_observacao" id="ds_observacao" class="col-xs-12 col-sm-8"/>
											</div>
										</div>
									</div>

									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Pagar
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
<script src="{{ asset('assets/js/jquery.maskMoney.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-additional-methods.min.js') }}"></script>
<script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-timepicker.min.js') }}"></script>	
<script src="{{ asset('assets/js/moment.min.js') }}"></script>	
<script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
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

  $(function() {
	  $("#vl_pagamento").maskMoney({thousands:'', decimal:',', allowZero:true, prefix: ' R$', allowNegative: true});
  })
  
  $('#formPagamento').validate({
		errorElement: 'div',
		errorClass: 'help-block',
		focusInvalid: false,
		ignore: "",
		rules: {			
			dt_pagamento: {
				required: true,
			},
			hr_pagamento: {
				required: true,
			},
			vl_pagamento: {
				required: true,
			}
		},

		messages: {			
			dt_pagamento: "Informe a data do pagamento",
			hr_pagamento: "Informe a hora do pagamento",
			vl_pagamento: "Informe o valor do pagamento"
		},


		highlight: function (e) {
			$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
		},

		success: function (e) {
			$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
			$(e).remove();
		},

		errorPlacement: function (error, element) {
			if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
				var controls = element.closest('div[class*="col-"]');
				if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
				else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
			}
			else if(element.is('.select2')) {
				error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
			}
			else if(element.is('.chosen-select')) {
				error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
			}
			else error.insertAfter(element.parent());
		}		
	});
</script>
@endsection