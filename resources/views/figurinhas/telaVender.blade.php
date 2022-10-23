@extends('template')

@section('titulo'){{ config('app.name') }} - Vender Figurinha @endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-book"></i>
								Figurinhas 
								&nbsp;
								<i class="ace-icon fa fa-credit-card"></i>
								Vender
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Figurinhas
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Propor Venda
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
								<div class="col-sm-3"></div>
								<div align="col-sm-9">
									<img alt="{{$jogador->ds_nome}}" src="{{url('figurinhas/mostrar')}}?id_jogador={{$jogador->id}}" />
								</div>
							</div>
							
							<div class="col-xs-12"><br/></div>
													
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" role="form" id="formVender" name="formVender" method="POST" action="{{ route('figurinhas.vender') }}">
									{{ csrf_field() }}
									{{ Form::hidden('id_jogador', $jogador->id) }}
									<input type="hidden" name="id_tela_oferecer" id="id_tela_oferecer" value="{{$id_tela_oferecer}}" />
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="vl_venda"> Valor Venda </label>

										<div class="col-sm-9">
											<div class="clearfix">
												<input type="text" name="vl_venda" id="vl_venda"/>
											</div>
										</div>
									</div>

									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Confirmar
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
<script>
$(function() {
	  $("#vl_venda").maskMoney({thousands:'', decimal:',', allowZero:true, prefix: ' $', allowNegative: false});
})
</script>
@endsection
