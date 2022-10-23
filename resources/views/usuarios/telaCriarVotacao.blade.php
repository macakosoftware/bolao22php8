@extends('template')

@section('titulo'){{ config('app.name') }} - Incluir Votação @endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-users"></i>
								Usuários 
								&nbsp;
								<i class="ace-icon fa fa-thumbs-up"></i>
								Votação
								&nbsp;
								<i class="ace-icon fa fa-plus"></i>
								Incluir
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Usuários
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Votação
									<i class="ace-icon fa fa-angle-double-right"></i>
									Incluir Nova Votação
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
								<form class="form-horizontal" role="form" id="formVotacao" name="formVotacao" method="POST" action="{{ route('usuarios.incluirVotacao') }}">
									{{ csrf_field() }}
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ds_titulo"> Título </label>

										<div class="col-sm-9">
											<input type="text" name="ds_titulo" id="ds_titulo" placeholder="Título" class="col-xs-10 col-sm-5" required/>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ds_descricao"> Descrição </label>

										<div class="col-sm-9">
											<input type="text" name="ds_descricao" id="ds_descricao" placeholder="Descrição" class="col-xs-12 col-sm-12" required/>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="cd_perfil"> Quantidade Opções</label>

										<div class="col-sm-9">
										{!! Form::select('qt_valores', $tb_qtd, 0, $attributes = ['class'=>'col-xs-10 col-sm-5', 'tabindex'=>'-1', 'id'=>'qt_valores']) !!}
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group voto1">
										<label class="col-sm-3 control-label no-padding-right" for="vl_voto1"> Valor 1 </label>
									
										<div class="col-sm-3 no-padding-right">
											<input type="text" name="vl_voto1" id="vl_voto1" placeholder="Valor 1" class="col-xs-10 col-sm-5" required/>
										</div>

										<div class="col-sm-6">
											<input type="text" name="ds_voto1" id="ds_voto1" placeholder="Descrição 1" class="col-xs-10 col-sm-5" required/>
										</div>
									</div>
									
									<div class="form-group voto2">
										<label class="col-sm-3 control-label no-padding-right" for="vl_voto2"> Valor 2 </label>
									
										<div class="col-sm-3">
											<input type="text" name="vl_voto2" id="vl_voto2" placeholder="Valor 2" class="col-xs-10 col-sm-5" required/>
										</div>

										<div class="col-sm-6">
											<input type="text" name="ds_voto2" id="ds_voto2" placeholder="Descrição 2" class="col-xs-10 col-sm-5" required/>
										</div>
									</div>

									<div class="form-group voto3">
										<label class="col-sm-3 control-label no-padding-right" for="vl_voto3"> Valor 3 </label>
									
										<div class="col-sm-3">
											<input type="text" name="vl_voto3" id="vl_voto3" placeholder="Valor 3" class="col-xs-10 col-sm-5" required/>
										</div>

										<div class="col-sm-6">
											<input type="text" name="ds_voto3" id="ds_voto3" placeholder="Descrição 3" class="col-xs-10 col-sm-5" required/>
										</div>
									</div>

									<div class="form-group voto4">
										<label class="col-sm-3 control-label no-padding-right" for="vl_voto4"> Valor 4 </label>
										
										<div class="col-sm-3">
											<input type="text" name="vl_voto4" id="vl_voto4" placeholder="Valor 4" class="col-xs-10 col-sm-5" required/>
										</div>

										<div class="col-sm-6">
											<input type="text" name="ds_voto4" id="ds_voto4" placeholder="Descrição 4" class="col-xs-10 col-sm-5" required/>
										</div>
									</div>

									<div class="form-group voto5">
										<label class="col-sm-3 control-label no-padding-right" for="vl_voto5"> Valor 5 </label>
										
										<div class="col-sm-3">
											<input type="text" name="vl_voto5" id="vl_voto5" placeholder="Valor 5" class="col-xs-10 col-sm-5" required/>
										</div>

										<div class="col-sm-6">
											<input type="text" name="ds_voto5" id="ds_voto5" placeholder="Descrição 5" class="col-xs-10 col-sm-5" required/>
										</div>
									</div>

									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Incluir
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
<script>
	$(document).ready(function() {
		for(i=1;i<=5;i++){
    		$('.voto'+i).hide();
    		$('#vl_voto'+i).prop('required',false);
        	$('#ds_voto'+i).prop('required',false);
		}
		
		$('#qt_valores').change(function() {
			for(i=1;i<=5;i++){
	    		$('.voto'+i).hide();
	    		$('#vl_voto'+i).prop('required',false);
	        	$('#ds_voto'+i).prop('required',false);
			}
        	for(i=1;i<=$(this).val();i++) {
            	$('.voto'+i).show();
            	$('#vl_voto'+i).prop('required',true);
	        	$('#ds_voto'+i).prop('required',true);            	            	
        	}        	
		});
	});
</script>
@endsection