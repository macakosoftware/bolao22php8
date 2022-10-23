@extends('template')

@section('titulo'){{ config('app.name') }} - Consultar Detalhes Jogo @endsection

@section('header_css')
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-timepicker.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/colorbox.min.css') }}" />
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
								<i class="ace-icon fa fa-info"></i>
								Consultar Detalhes
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Jogos
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Consultar Detalhes do Jogo
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
								
									{{ csrf_field() }}									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="id_selecao1"> Situação </label>

										<div class="col-sm-9">
											<label class="col-sm-12 control-label" style="text-align: left">
											{{ $jogo->statusJogo->ds_status }}
											</label>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="id_selecao1"> Jogo </label>

										<div class="col-sm-9">
											<label class="col-sm-12 control-label" style="text-align: left">
											<img src="{{ asset('images/brasoes') }}/{{$jogo->selecao1->ds_icone}}" />
											{{ $jogo->selecao1->ds_nome }}
											<li class="ace-icon fa fa-times"></li>
											{{ $jogo->selecao2->ds_nome }}
											<img src="{{ asset('images/brasoes') }}/{{$jogo->selecao2->ds_icone}}" />
											</label>
										</div>
									</div>
									
									@if ($jogo->ds_selecao1 != '')
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="id_selecao1"> Descrição </label>

										<div class="col-sm-4">
											<label class="col-sm-12 control-label" style="text-align: left">{{ $jogo->ds_selecao1 }}</label>
										</div>
										<div class="col-sm-1">
											<div class="text-center">										
											<li class="ace-icon fa fa-times"></li>
											</div>
										</div>
										<div class="col-sm-4">
											<label class="col-sm-12 control-label" style="text-align: left">{{ $jogo->ds_selecao2 }}</label>	
										</div>
									</div>
									@endif
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="dt_jogo"> Data </label>

										<div class="col-sm-9">
											<label class="col-sm-12 control-label" style="text-align: left">{{ \Carbon\Carbon::parse($jogo->dt_jogo)->format('d/m/Y') }}</label>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hr_jogo"> Horário </label>

										<div class="col-sm-9">
											<label class="col-sm-12 control-label" style="text-align: left">{{ $jogo->hr_jogo }}</label>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="id_estadio">Estádio</label>

										<div class="col-sm-9">
										<label class="col-sm-12 control-label" style="text-align: left">{{  $jogo->estadio->ds_nome }}</label>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="id_estadio">&nbsp;</label>

										<div class="col-sm-9">
										<label class="col-sm-12 control-label" style="text-align: left">
										<a href="{{ asset('images/estadios') }}/{{$jogo->estadio->ds_foto}}" data-rel="colorbox">
											<img width="150" height="150" alt="150x150" src="{{ asset('images/estadios') }}/{{$jogo->estadio->ds_foto}}" />
										</a>
										
										</label>
										</div>
									</div>
									
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="id_ranking">Tipo Jogo</label>

										<div class="col-sm-9">
										<label class="col-sm-12 control-label" style="text-align: left">{{ $jogo->tipoRanking->ds_nome }}</label>
										</div>
									</div>
									
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
	<script src="{{ asset('assets/js/jquery.colorbox.min.js') }}"></script>		
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

			var $overflow = '';
			var colorbox_params = {
				rel: 'colorbox',
				reposition:true,
				scalePhotos:true,
				scrolling:false,
				previous:'<i class="ace-icon fa fa-arrow-left"></i>',
				next:'<i class="ace-icon fa fa-arrow-right"></i>',
				close:'&times;',
				current:'{current} of {total}',
				maxWidth:'100%',
				maxHeight:'100%',
				onOpen:function(){
					$overflow = document.body.style.overflow;
					document.body.style.overflow = 'hidden';
				},
				onClosed:function(){
					document.body.style.overflow = $overflow;
				},
				onComplete:function(){
					$.colorbox.resize();
				}
			};

			$('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
			$("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange fa-spin'></i>");//let's add a custom loading icon
			
			
			$(document).one('ajaxloadstart.page', function(e) {
				$('#colorbox, #cboxOverlay').remove();
		   });
		});
	</script>
@endsection