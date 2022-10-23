@extends('template')

@section('titulo'){{ config('app.name') }} - Incluir Usuário @endsection

@section('header_css')
<link rel="stylesheet" href="{{asset('assets/css/chosen.min.css')}}" /> 
@endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-book"></i>
								Figurinhas 
								&nbsp;
								<i class="ace-icon fa fa-exchange"></i>
								<i class="ace-icon fa fa-credit-card"></i>
								CriarProposta
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Figurinhas
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Criar Nova Proposta - Ofereça Figurinhas, Faça uma Proposta em Brothetas ou Faça um MIX!
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
							
							<div class="col-xs-12">
							<h4>Usuário</h4>
							<p>							
							@if (\App\Funcoes\VerificaAvatar::verificar($transacao->id_user))
							<img width="30px" height="30px" src="data:image/png;base64,{{ base64_encode(Storage::get('avatars/'.$transacao->id_user))}}" alt="Photo" />
							@else
							<img width="30px" height="30px" src="{{ asset('assets/images/avatars/user.jpg') }}" alt="Photo" />                                								
							@endif	
							{{$transacao->usuario->name}}
							</p>	
							</div>
							
							<div class="col-xs-12">
							<h4>Seleção</h4>
							<p>
							<img src="{{ asset('images/brasoes') }}/{{$transacao->jogador->selecao->ds_icone}}" />
							{{ $transacao->jogador->selecao->ds_nome }}
							</p>
							</div>
							
							<div class="col-xs-12">
							<h4>Nome Jogador</h4>
							<p>{{ $transacao->jogador->ds_nome }}<p/>
							</div>
									
							<div class="col-xs-12">
							<h4>Tipo Transação</h4>							
							@if ($transacao->tp_transacao == \App\Models\TransacaoFigurinha::TIPO_TROCA)
							<p>Troca</p>
							@elseif ($transacao->tp_transacao == \App\Models\TransacaoFigurinha::TIPO_VENDA)
							<p>Venda</p>
							@endif
							</div>
							
							@if ($transacao->vl_venda > 0)		
							<div class="col-xs-12">
							<h4>Valor</h4>
							<p>{{number_format($transacao->vl_venda,2,',','')}}</p>							
							</div>	
							@endif
							
						</div>
						
						<hr />
						
						<div class="row">
							<div class="col-sm-12">
								<div class="widget-box">
									<div class="widget-header widget-header-flat">
										<h4 class="widget-title smaller">											
											Proposta
										</h4>
									</div>

								<div class="widget-body">
								<div class="widget-main">

								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" role="form" id="formProposta" name="formProposta" method="POST" action="{{ route('figurinhas.criarProposta') }}">
									{{ csrf_field() }}
									{{ Form::hidden('id_oferta', $transacao->id) }}
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="vl_pagamento">Observação</label>

										<div class="col-sm-9">
											<div class="clearfix">
												<input type="text" name="ds_observacao" id="ds_observacao" class="col-xs-12 col-sm-8"/>
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="vl_oferta"> Valor Oferta </label>

										<div class="col-sm-9">
											<div class="clearfix">
												<input type="text" name="vl_oferta" id="vl_oferta"/>
											</div>
										</div>
									</div>
									
									@if ($tem_repetida)
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="vl_saldo"> Para </label>

										<div class="col-sm-9">
										<select multiple="" name="tb_figurinhas[]" id="tb_figurinhas" class="chosen-select form-control" id="form-field-select-4" data-placeholder="Selecione Figurinhas Para Troca...">
										@foreach($tb_figurinhas as $figurinha)
											<option value="{{$figurinha['figurinha']['id_jogador']}}">[{{$figurinha['figurinha']['jogador']->selecao->ds_nome}}] {{$figurinha['figurinha']['jogador']->ds_nome}} @if($figurinha['id_ele_tem']) [Recebedor Já Tem] @else [Recebedor NÃO Tem] @endif</option>
										@endforeach	
										</select>										
										</div>
									</div>
									@endif

									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Criar Proposta
											</button>
										</div>
									</div>
									</form>
									
									</div>
									</div>
								</div>
								</div>								
							</div><!-- /.row -->						
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
@endsection

@section('pos_script')
<script src="{{ asset('assets/js/jquery.maskMoney.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/jquery.bootstrap-duallistbox.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-multiselect.min.js') }}"></script>
<script src="{{asset('assets/js/chosen.jquery.min.js')}}"></script>
<script>
$(function() {
	  $("#vl_oferta").maskMoney({thousands:'', decimal:',', allowZero:true, prefix: ' $', allowNegative: false});
})
@if ($tem_repetida)	
if(!ace.vars['touch']) {
	$('.chosen-select').chosen({allow_single_deselect:true}); 
	//resize the chosen on window resize

	$(window)
	.off('resize.chosen')
	.on('resize.chosen', function() {
		$('.chosen-select').each(function() {
			 var $this = $(this);
			 $this.next().css({'width': $this.parent().width()});
		})
	}).trigger('resize.chosen');
	//resize chosen on sidebar collapse/expand
	$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
		if(event_name != 'sidebar_collapsed') return;
		$('.chosen-select').each(function() {
			 var $this = $(this);
			 $this.next().css({'width': $this.parent().width()});
		})
	});


	$('#chosen-multiple-style .btn').on('click', function(e){
		var target = $(this).find('input[type=radio]');
		var which = parseInt(target.val());
		if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
		 else $('#form-field-select-4').removeClass('tag-input-style');
	});
}
@endif
</script>
@endsection
