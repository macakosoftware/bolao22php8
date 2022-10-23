@extends('template')

@section('titulo'){{ config('app.name') }} - Perfil @endsection

@section('header_css') @endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-male"></i>
								Jogadores
								&nbsp;
								<i class="ace-icon fa fa-edit"></i>
								Importar
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Jogadores
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Importar Arquivo de Jogadores
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
								{!! Form::open(array('route' => 'jogadores.importar', 'class' => 'form-horizontal', 'files' => true, 'name' => 'formImportar', 'id' => 'formImportar')) !!}
									{{ csrf_field() }}									
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="foto_profile"> Arquivo .CSV </label>
							
										<div class="col-sm-9">
												<input type="file" id="arquivo_jogadores" name="arquivo_jogadores" />																										
										</div>
									</div>

									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Importar
											</button>
										</div>
									</div>
									{!! Form::close() !!}
								</div>
							</div><!-- /.row -->						
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
@endsection

@section('pos_script')
	<script>	
	$(document).ready(function() {
		if ($('#id_alterar.senha').is(':checked')){
			$('.pass_section').show();
			$('#password').prop('required',true);
        	$('#password_confirmation').prop('required',true);
		}
		else{				
			$('.pass_section').hide();
		}
		$('#id_alterar_senha').change(function() {
    	if($(this).is(":checked")) {
        	$('.pass_section').show();
        	$('#password').prop('required',true);
        	$('#password_confirmation').prop('required',true);
    	}
    	else {
    		$('.pass_section').hide();
    		$('#password').prop('required',false);
        	$('#password_confirmation').prop('required',false);
    	}
		});
	});

	$('#foto_perfil').ace_file_input({
		no_file:'Selecione foto...',
		btn_choose:'Choose',
		btn_change:'Change',
		droppable:false,
		onchange:null,
		thumbnail: true , 
		whitelist:'gif|png|jpg|jpeg'
		//blacklist:'exe|php'
		//onchange:''
		//
	});

	</script>
@endsection