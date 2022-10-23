@extends('template')

@section('titulo'){{ config('app.name') }} - Creditar Brothetas @endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-money"></i>
								Brothetas 
								&nbsp;
								<i class="ace-icon fa fa-plus-square"></i>
								Creditar
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Brothetas
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Realizar Crédito
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
								<form class="form-horizontal" role="form" id="formCredito" name="formCredito" method="POST" action="{{ route('usuario.creditarPontosXP') }}">
									{{ csrf_field() }}
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="cd_perfil"> Usuario </label>

										<div class="col-sm-9">
										{!! Form::select('id_usuario', $tb_usuarios, 0, $attributes = ['class'=>'col-xs-10 col-sm-5', 'tabindex'=>'-1']) !!}
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="vl_credito"> Valor Crédito </label>

										<div class="col-sm-9">
											<div class="clearfix">
												<input type="text" name="vl_credito" id="vl_credito"/>
											</div>
										</div>
									</div>
									
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
												Creditar
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
<script src="{{ asset('assets/js/jquery.maskMoney.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-additional-methods.min.js') }}"></script>
<script>
$(function() {
	  $("#vl_credito").maskMoney({thousands:'', decimal:',', allowZero:true, allowNegative: false});
})

$('#formCredito').validate({
		errorElement: 'div',
		errorClass: 'help-block',
		focusInvalid: false,
		ignore: "",
		rules: {
			vl_credito: {
				required: true
			},
			ds_observacao: {
				required: true
			}
		},

		messages: {
			vl_pagamento: "Informe o valor do crédito",
			ds_observacao: "Informe a descrição do crédito"
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